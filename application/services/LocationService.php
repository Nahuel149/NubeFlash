<?php

/**
 * LocationServiceImpl Class
 * 
 * This service handles finding and creating location records for the application
 */
class LocationServiceImpl 
{
    private $codegen_model;
    
    /**
     * Constructor
     */
    public function __construct($codegen_model)
    {
        $this->codegen_model = $codegen_model;
        log_message('debug', 'LocationServiceImpl initialized with codegen_model: ' . (is_object($codegen_model) ? 'YES' : 'NO'));
    }
    
    /**
     * Find a province by name or create if it doesn't exist
     */
    public function findOrCreateProvince($countryId, $provinceName)
    {
        // Normalize input
        $provinceName = trim($provinceName);
        log_message('debug', 'findOrCreateProvince called - countryId: ' . $countryId . ', provinceName: ' . $provinceName);
        
        // Make sure ACTIVE constant is defined
        if (!defined('ACTIVE')) {
            define('ACTIVE', 1);
        }
        
        // Look for existing province with same name in this country
        $province = $this->codegen_model->row('provinces', '*', 'name = "' . $provinceName . '" AND country_id = "' . $countryId . '" AND active = "' . ACTIVE . '"');
        
        if (!$province) {
            log_message('debug', 'Province not found, creating new one');
            
            // Create new province
            $data = [
                'name' => $provinceName,
                'country_id' => $countryId,
                'code' => $this->generateProvinceCode($provinceName),
                'active' => 1, // Hardcoded value to ensure it works
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            try {
                // Direct DB insertion to bypass any ORM issues
                $this->codegen_model->db->insert('provinces', $data);
                $provinceId = $this->codegen_model->db->insert_id();
                
                log_message('debug', 'New province created with ID: ' . $provinceId);
                
                // Ensure we have a proper province object
                $province = new stdClass();
                $province->province_id = $provinceId;
                $province->name = $provinceName;
                $province->country_id = $countryId;
                $province->code = $data['code'];
                $province->active = 1;
                
                return $province;
            } catch (Exception $e) {
                log_message('error', 'Error creating province: ' . $e->getMessage());
                throw $e;
            }
        } else {
            log_message('debug', 'Found existing province with ID: ' . $province->province_id);
        }
        
        return $province;
    }
    
    /**
     * Find a destination by name/postal code or create if it doesn't exist
     */
    public function findOrCreateDestination($provinceId, $destinationName, $postalCode)
    {
        // Normalize input
        $destinationName = trim($destinationName);
        $postalCode = trim($postalCode);
        log_message('debug', 'findOrCreateDestination called - provinceId: ' . $provinceId . ', destinationName: ' . $destinationName . ', postalCode: ' . $postalCode);
        
        // Validate postal code - it's required by database constraints
        if (empty($postalCode)) {
            log_message('error', 'Empty postal code provided for destination: ' . $destinationName);
            throw new Exception('El código postal no puede estar vacío.');
        }
        
        // Make sure ACTIVE constant is defined
        if (!defined('ACTIVE')) {
            define('ACTIVE', 1);
        }
        
        // First, check for existing destination with exact postal code match (regardless of active status)
        // This helps prevent unique constraint violations
        $existingPostalCode = $this->codegen_model->row('destinations', '*', 'postal_code = "' . $postalCode . '"');
        if ($existingPostalCode) {
            log_message('debug', 'Found existing destination with postal code: ' . $postalCode . ', ID: ' . $existingPostalCode->destination_id);
            // If we found an existing destination with this postal code, return it
            // This prevents unique constraint violations on postal_code
            return $existingPostalCode;
        }
        
        // Look for active destination with same postal code or name in this province
        $destination = null;
        
        if (!empty($destinationName)) {
            $destination = $this->codegen_model->row('destinations', '*', 'name = "' . $destinationName . '" AND province_id = "' . $provinceId . '" AND active = "' . ACTIVE . '"');
        }
            
        if (!$destination) {
            log_message('debug', 'Destination not found, creating new one');
            
            // Create new destination
            $data = [
                'name' => $destinationName,
                'province_id' => $provinceId,
                'postal_code' => $postalCode,
                'active' => 1, // Hardcoded value to ensure it works
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            try {
                // Direct DB insertion to bypass any ORM issues
                $this->codegen_model->db->insert('destinations', $data);
                $destinationId = $this->codegen_model->db->insert_id();
                
                if (!$destinationId) {
                    $error = $this->codegen_model->db->error();
                    log_message('error', 'Database error creating destination: ' . json_encode($error));
                    throw new Exception('Error al crear la localidad: ' . $error['message']);
                }
                
                log_message('debug', 'New destination created with ID: ' . $destinationId);
                
                // Ensure we have a proper destination object
                $destination = new stdClass();
                $destination->destination_id = $destinationId;
                $destination->name = $destinationName;
                $destination->province_id = $provinceId;
                $destination->postal_code = $postalCode;
                $destination->active = 1;
                
                return $destination;
            } catch (Exception $e) {
                log_message('error', 'Error creating destination: ' . $e->getMessage());
                throw $e;
            }
        } else {
            log_message('debug', 'Found existing destination with ID: ' . $destination->destination_id);
        }
        
        return $destination;
    }
    
    /**
     * Handle manual location input from any form
     */
    public function handleManualLocationInput($countryId, $provinceInput, $provinceManual, $destinationInput, $destinationManual, $postalCodeManual)
    {
        $provinceId = null;
        $destinationId = null;
        
        log_message('debug', '==================== LOCATION INPUT START ====================');
        log_message('debug', 'handleManualLocationInput - countryId: ' . $countryId . 
            ', provinceInput: ' . $provinceInput . 
            ', provinceManual: ' . $provinceManual . 
            ', destinationInput: ' . $destinationInput . 
            ', destinationManual: ' . $destinationManual . 
            ', postalCodeManual: ' . $postalCodeManual);
        
        // Debug check for data types and empty checks
        log_message('debug', 'provinceInput type: ' . gettype($provinceInput) . ', value: "' . $provinceInput . '"');
        log_message('debug', 'destinationInput type: ' . gettype($destinationInput) . ', value: "' . $destinationInput . '"');
        log_message('debug', 'provinceInput === "other": ' . ($provinceInput === 'other' ? 'true' : 'false'));
        log_message('debug', 'destinationInput === "other": ' . ($destinationInput === 'other' ? 'true' : 'false'));
        log_message('debug', 'empty(provinceManual): ' . (empty($provinceManual) ? 'true' : 'false'));
        log_message('debug', 'empty(destinationManual): ' . (empty($destinationManual) ? 'true' : 'false'));
        log_message('debug', 'postalCodeManual: ' . $postalCodeManual);
        
        try {
            // Validate postal code if manual destination
            if ($destinationInput === 'other' && empty(trim($postalCodeManual))) {
                log_message('error', 'Empty postal code provided for manual destination');
                throw new Exception('El código postal es obligatorio cuando se ingresa una localidad manual.');
            }
            
            // Handle province
            if ($provinceInput === 'other' && !empty($provinceManual)) {
                log_message('debug', 'Creating manual province: ' . $provinceManual);
                $province = $this->findOrCreateProvince($countryId, $provinceManual);
                $provinceId = $province->province_id;
                log_message('debug', 'Created/found province with ID: ' . $provinceId);
            } elseif (is_numeric($provinceInput)) {
                $provinceId = $provinceInput;
                log_message('debug', 'Using existing province with ID: ' . $provinceId);
            }
            
            log_message('debug', 'After province handling - provinceId: ' . $provinceId);
            
            // Handle destination
            log_message('debug', 'Destination condition check: provinceId && destinationInput === "other" && !empty(destinationManual)');
            log_message('debug', 'Condition values: ' . ($provinceId ? 'true' : 'false') . ' && ' . 
                        ($destinationInput === 'other' ? 'true' : 'false') . ' && ' . 
                        (!empty($destinationManual) ? 'true' : 'false'));
            
            if ($provinceId && $destinationInput === 'other' && !empty($destinationManual)) {
                log_message('debug', 'Creating manual destination: ' . $destinationManual . ' with postal code: ' . $postalCodeManual);
                
                // Additional validation for postal code
                if (empty(trim($postalCodeManual))) {
                    log_message('error', 'Empty postal code detected before calling findOrCreateDestination');
                    throw new Exception('El código postal no puede estar vacío.');
                }
                
                $destination = $this->findOrCreateDestination($provinceId, $destinationManual, $postalCodeManual);
                $destinationId = $destination->destination_id;
                log_message('debug', 'Created/found destination with ID: ' . $destinationId);
            } elseif (is_numeric($destinationInput)) {
                $destinationId = $destinationInput;
                log_message('debug', 'Using existing destination with ID: ' . $destinationId);
            } else {
                log_message('debug', 'No destination creation/selection occurred. Condition failed.');
            }
            
            $result = [
                'province_id' => $provinceId,
                'destination_id' => $destinationId
            ];
            
            // Final validation check
            if ($destinationInput === 'other' && empty($destinationId)) {
                log_message('error', 'Failed to create or find destination. Manual destination was requested but no destination_id was set.');
                throw new Exception('Error al crear o encontrar la localidad. Por favor, intente nuevamente.');
            }
            
            log_message('debug', 'handleManualLocationInput returning: ' . json_encode($result));
            log_message('debug', '==================== LOCATION INPUT END ====================');
            return $result;
        } catch (Exception $e) {
            log_message('error', 'LocationServiceImpl::handleManualLocationInput - ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Generate a province code from name
     */
    private function generateProvinceCode($name)
    {
        // Generate base code
        $baseCode = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $name), 0, 5));
        
        // Check if code exists
        $existingCode = $this->codegen_model->row('provinces', 'province_id', 'code = "' . $baseCode . '"');
        
        if ($existingCode) {
            // If code exists, append a random suffix to make it unique
            $randomSuffix = rand(1, 999);
            $newCode = substr($baseCode, 0, 5 - strlen($randomSuffix)) . $randomSuffix;
            
            // Log the code generation
            log_message('debug', 'Province code already exists, generated new code: ' . $newCode);
            
            return $newCode;
        }
        
        return $baseCode;
    }
} 