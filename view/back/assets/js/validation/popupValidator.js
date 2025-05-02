/**
 * PopupValidator - Système de popup pour le contrôle de saisie
 * Ce script permet d'afficher des messages de validation dans une popup stylisée
 */

class PopupValidator {
    constructor() {
        this.initPopupElements();
    }

    /**
     * Initialise les éléments de la popup dans le DOM
     */
    initPopupElements() {
        // Vérifier si les éléments existent déjà
        if (document.getElementById('validation-popup')) {
            return;
        }

        // Créer l'overlay
        const overlay = document.createElement('div');
        overlay.id = 'validation-overlay';
        overlay.className = 'validation-overlay';
        
        // Créer la popup
        const popup = document.createElement('div');
        popup.id = 'validation-popup';
        popup.className = 'validation-popup';
        
        // Contenu de la popup
        popup.innerHTML = `
            <div class="popup-icon">
                <i class="fas fa-check-circle" id="success-icon"></i>
                <i class="fas fa-exclamation-circle" id="error-icon"></i>
            </div>
            <div class="popup-message" id="popup-message"></div>
            <button class="popup-button" id="popup-button">OK</button>
        `;
        
        // Ajouter les éléments au body
        document.body.appendChild(overlay);
        document.body.appendChild(popup);
        
        // Ajouter les styles CSS
        this.addStyles();
        
        // Configurer le bouton de fermeture
        document.getElementById('popup-button').addEventListener('click', () => {
            this.hidePopup();
        });
    }

    /**
     * Ajoute les styles CSS nécessaires
     */
    addStyles() {
        // Vérifier si les styles existent déjà
        if (document.getElementById('validation-popup-styles')) {
            return;
        }
        
        const styleElement = document.createElement('style');
        styleElement.id = 'validation-popup-styles';
        styleElement.textContent = `
            .validation-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9998;
                display: none;
            }
            
            .validation-popup {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #fff;
                padding: 25px;
                border-radius: 10px;
                box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
                z-index: 9999;
                display: none;
                min-width: 300px;
                max-width: 80%;
                text-align: center;
            }
            
            .validation-popup.success {
                border-top: 5px solid #28a745;
            }
            
            .validation-popup.error {
                border-top: 5px solid #dc3545;
            }
            
            .popup-icon {
                font-size: 48px;
                margin-bottom: 15px;
            }
            
            .popup-icon #success-icon {
                color: #28a745;
                display: none;
            }
            
            .popup-icon #error-icon {
                color: #dc3545;
                display: none;
            }
            
            .validation-popup.success #success-icon {
                display: inline-block;
            }
            
            .validation-popup.error #error-icon {
                display: inline-block;
            }
            
            .popup-message {
                font-size: 18px;
                margin-bottom: 20px;
                color: #333;
            }
            
            .popup-button {
                background: #1e3c72;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                transition: all 0.3s ease;
            }
            
            .popup-button:hover {
                background: #2a5298;
            }
        `;
        
        document.head.appendChild(styleElement);
    }

    /**
     * Affiche la popup avec un message
     * @param {string} message - Le message à afficher
     * @param {boolean} isSuccess - True pour succès, False pour erreur
     * @param {Function} callback - Fonction à exécuter après la fermeture de la popup
     */
    showPopup(message, isSuccess = false, callback = null) {
        const popup = document.getElementById('validation-popup');
        const overlay = document.getElementById('validation-overlay');
        const popupMessage = document.getElementById('popup-message');
        
        // Configurer le message
        popupMessage.textContent = message;
        
        // Configurer le type de popup
        if (isSuccess) {
            popup.classList.add('success');
            popup.classList.remove('error');
        } else {
            popup.classList.add('error');
            popup.classList.remove('success');
        }
        
        // Afficher la popup et l'overlay
        popup.style.display = 'block';
        overlay.style.display = 'block';
        
        // Configurer le callback si fourni
        if (callback) {
            this.callback = callback;
        } else {
            this.callback = null;
        }
    }

    /**
     * Cache la popup
     */
    hidePopup() {
        const popup = document.getElementById('validation-popup');
        const overlay = document.getElementById('validation-overlay');
        
        popup.style.display = 'none';
        overlay.style.display = 'none';
        
        // Exécuter le callback si défini
        if (this.callback) {
            this.callback();
            this.callback = null;
        }
    }
    
    /**
     * Valide un formulaire avec des règles spécifiées
     * @param {HTMLFormElement} form - Le formulaire à valider
     * @param {Object} rules - Les règles de validation
     * @returns {boolean} - True si la validation est réussie, sinon false
     */
    validateForm(form, rules) {
        for (const fieldName in rules) {
            const field = form.elements[fieldName];
            const fieldRules = rules[fieldName];
            
            // Vérifier si le champ existe
            if (!field) {
                console.error(`Le champ "${fieldName}" n'existe pas dans le formulaire.`);
                continue;
            }
            
            const value = field.value.trim();
            
            // Vérifier les règles pour ce champ
            for (const rule of fieldRules) {
                switch (rule.type) {
                    case 'required':
                        if (value === '') {
                            this.showPopup(rule.message || `Le champ ${fieldName} est requis.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'minLength':
                        if (value.length < rule.value) {
                            this.showPopup(rule.message || `Le champ ${fieldName} doit contenir au moins ${rule.value} caractères.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'maxLength':
                        if (value.length > rule.value) {
                            this.showPopup(rule.message || `Le champ ${fieldName} ne doit pas dépasser ${rule.value} caractères.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'numeric':
                        if (isNaN(value) || value === '') {
                            this.showPopup(rule.message || `Le champ ${fieldName} doit être un nombre.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'min':
                        if (parseFloat(value) < rule.value) {
                            this.showPopup(rule.message || `Le champ ${fieldName} doit être au moins ${rule.value}.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'max':
                        if (parseFloat(value) > rule.value) {
                            this.showPopup(rule.message || `Le champ ${fieldName} ne doit pas dépasser ${rule.value}.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            this.showPopup(rule.message || `Veuillez entrer une adresse email valide.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'pattern':
                        const regex = new RegExp(rule.pattern);
                        if (!regex.test(value)) {
                            this.showPopup(rule.message || `Le format du champ ${fieldName} est invalide.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                        
                    case 'custom':
                        if (!rule.validate(value, form)) {
                            this.showPopup(rule.message || `Le champ ${fieldName} est invalide.`, false);
                            field.focus();
                            return false;
                        }
                        break;
                }
            }
        }
        
        return true;
    }
}

// Créer une instance globale
const popupValidator = new PopupValidator();