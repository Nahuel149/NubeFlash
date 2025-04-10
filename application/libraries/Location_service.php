<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location_service Library
 * 
 * This library acts as a wrapper for the LocationServiceImpl class to be used in the CodeIgniter framework
 */
class Location_service {
    
    // Reference to the CodeIgniter instance
    private $CI;
    
    // The actual service instance
    private $service;
    
    /**
     * Constructor
     * 
     * @param array $params Parameters to initialize the service
     */
    public function __construct($params = array())
    {
        // Get the CodeIgniter instance
        $this->CI =& get_instance();
        
        // Create a new instance of the service
        require_once APPPATH . 'services/LocationService.php';
        
        // Get the codegen_model from params or load it if not provided
        $codegen_model = isset($params['codegen_model']) ? $params['codegen_model'] : null;
        if (!$codegen_model) {
            $this->CI->load->model('Codegen_model', 'codegen_model');
            $codegen_model = $this->CI->codegen_model;
        }
        
        // Create the service instance
        $this->service = new \LocationServiceImpl($codegen_model);
    }
    
    /**
     * Find or create a province by name
     * 
     * @param int $countryId Country ID
     * @param string $provinceName Province name
     * @return object Province object
     */
    public function findOrCreateProvince($countryId, $provinceName)
    {
        return $this->service->findOrCreateProvince($countryId, $provinceName);
    }
    
    /**
     * Find or create a destination by name and postal code
     * 
     * @param int $provinceId Province ID
     * @param string $destinationName Destination name
     * @param string $postalCode Postal code
     * @return object Destination object
     */
    public function findOrCreateDestination($provinceId, $destinationName, $postalCode)
    {
        return $this->service->findOrCreateDestination($provinceId, $destinationName, $postalCode);
    }
    
    /**
     * Handle manual location input from forms
     * 
     * @param int $countryId Country ID
     * @param mixed $provinceInput Province ID or 'other'
     * @param string $provinceManual Manual province name
     * @param mixed $destinationInput Destination ID or 'other'
     * @param string $destinationManual Manual destination name
     * @param string $postalCodeManual Manual postal code
     * @return array Array with province_id and destination_id
     */
    public function handleManualLocationInput($countryId, $provinceInput, $provinceManual, $destinationInput, $destinationManual, $postalCodeManual)
    {
        // Validate inputs
        if (empty($countryId) || !is_numeric($countryId)) {
            throw new Exception('Country ID is required');
        }
        
        // Sanitize inputs
        $postalCodeManual = trim($postalCodeManual);
        $provinceManual = trim($provinceManual);
        $destinationManual = trim($destinationManual);
        
        // Validate postal code format if provided
        if (!empty($postalCodeManual) && !preg_match('/^[a-zA-Z0-9\-\s]{1,10}$/', $postalCodeManual)) {
            throw new Exception('Invalid postal code format');
        }
        
        return $this->service->handleManualLocationInput(
            $countryId, 
            $provinceInput, 
            $provinceManual, 
            $destinationInput, 
            $destinationManual, 
            $postalCodeManual
        );
    }
} 