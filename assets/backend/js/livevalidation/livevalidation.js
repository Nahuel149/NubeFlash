// LiveValidation Class
var LiveValidation = function(element, options) {
    this.initialize(element, options);
};

LiveValidation.VERSION = '1.3';

LiveValidation.prototype = {
    validClass: 'valid',
    invalidClass: 'invalid',
    messageClass: 'validation-message',
    
    initialize: function(element, options) {
        this.element = element;
        this.validations = [];
        this.options = options || {};
        this.form = this.element.form;
        this.element.classList.remove(this.invalidClass);
        this.element.classList.remove(this.validClass);
    },
    
    add: function(validation) {
        this.validations.push(validation);
        return this;
    },
    
    remove: function(validation) {
        this.validations = this.validations.filter(v => v !== validation);
        return this;
    },
    
    validate: function() {
        var value = this.element.value;
        var valid = true;
        
        for (var i = 0; i < this.validations.length; i++) {
            if (!this.validations[i](value)) {
                valid = false;
                break;
            }
        }
        
        if (valid) {
            this.element.classList.remove(this.invalidClass);
            this.element.classList.add(this.validClass);
        } else {
            this.element.classList.remove(this.validClass);
            this.element.classList.add(this.invalidClass);
        }
        
        return valid;
    }
};

// Validation Functions
var Validate = {
    Presence: function(value) {
        return value !== null && value.trim() !== '';
    },
    
    Email: function(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },
    
    Numericality: function(value) {
        return !isNaN(value) && value !== '';
    },
    
    Length: function(options) {
        return function(value) {
            if (options.minimum && value.length < options.minimum) {
                return false;
            }
            if (options.maximum && value.length > options.maximum) {
                return false;
            }
            return true;
        };
    },
    
    Confirmation: function(options) {
        return function(value) {
            var confirmElement = document.getElementById(options.match);
            return confirmElement && value === confirmElement.value;
        };
    }
};

// Add event listeners to form elements
document.addEventListener('DOMContentLoaded', function() {
    var forms = document.getElementsByTagName('form');
    for (var i = 0; i < forms.length; i++) {
        var elements = forms[i].elements;
        for (var j = 0; j < elements.length; j++) {
            var element = elements[j];
            if (element.getAttribute('data-validates')) {
                element.addEventListener('blur', function() {
                    if (this.LiveValidation) {
                        this.LiveValidation.validate();
                    }
                });
            }
        }
    }
}); 