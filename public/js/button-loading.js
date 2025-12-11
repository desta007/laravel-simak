/**
 * Button Loading Handler
 * Secara otomatis menambahkan efek loading pada tombol saat form disubmit
 * 
 * Features:
 * - Automatically detects all forms and submit buttons
 * - Shows loading spinner and text
 * - Disables button to prevent double submit
 * - Handles target="_blank" forms properly
 * - Works with modals
 * - Works with AJAX forms (optional)
 */

(function($) {
    'use strict';

    // Configuration
    var config = {
        loadingText: {
            'submit': 'Menyimpan...',
            'login': 'Memproses...',
            'log in': 'Memproses...',
            'simpan': 'Menyimpan...',
            'save': 'Menyimpan...',
            'update': 'Memperbarui...',
            'delete': 'Menghapus...',
            'hapus': 'Menghapus...',
            'view': 'Memuat...',
            'print': 'Mencetak...',
            'pdf': 'Membuat PDF...',
            'excel': 'Membuat Excel...',
            'export': 'Mengekspor...',
            'search': 'Mencari...',
            'cari': 'Mencari...',
            'filter': 'Memfilter...',
            'proses': 'Memproses...',
            'process': 'Memproses...',
            'kirim': 'Mengirim...',
            'send': 'Mengirim...',
            'reset': 'Mereset...',
            'default': 'Memproses...'
        },
        spinnerHTML: '<span class="btn-loading-spinner"></span>',
        resetDelay: 3000, // Reset button after 3 seconds for target="_blank" forms
        excludeSelectors: [
            '.no-loading',
            '[data-no-loading]',
            '.btn-no-loading',
            '[type="reset"]',
            '.cancel-btn',
            '.close',
            '[data-dismiss]',
            '.dataTables_wrapper button',
            '.dt-buttons button'
        ]
    };

    /**
     * Get appropriate loading text based on button text
     */
    function getLoadingText(buttonText) {
        if (!buttonText) return config.loadingText['default'];
        
        buttonText = buttonText.toLowerCase().trim();
        
        // Check for exact match first
        if (config.loadingText[buttonText]) {
            return config.loadingText[buttonText];
        }
        
        // Check for partial match
        for (var key in config.loadingText) {
            if (buttonText.indexOf(key) !== -1) {
                return config.loadingText[key];
            }
        }
        
        return config.loadingText['default'];
    }

    /**
     * Check if button should be excluded from loading effect
     */
    function shouldExclude(button) {
        var $btn = $(button);
        
        // Check exclude selectors
        for (var i = 0; i < config.excludeSelectors.length; i++) {
            if ($btn.is(config.excludeSelectors[i])) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Set button to loading state
     */
    function setButtonLoading($btn) {
        if ($btn.hasClass('btn-loading') || shouldExclude($btn)) {
            return;
        }

        // Store original content
        var originalContent = $btn.html();
        var originalWidth = $btn.outerWidth();
        
        $btn.data('original-content', originalContent);
        $btn.data('original-width', originalWidth);
        
        // Get button text (strip HTML tags)
        var buttonText = $btn.text();
        var loadingText = getLoadingText(buttonText);
        
        // Set minimum width to prevent button shrinking
        $btn.css('min-width', originalWidth + 'px');
        
        // Add loading class and disable
        $btn.addClass('btn-loading');
        $btn.prop('disabled', true);
        
        // Create loading content
        var loadingHTML = config.spinnerHTML + '<span class="btn-loading-text">' + loadingText + '</span>';
        
        // Replace content with loading state
        $btn.html('<span class="btn-original-content" style="visibility:hidden;">' + originalContent + '</span>' +
                  '<span class="btn-loading-content">' + loadingHTML + '</span>');
    }

    /**
     * Reset button to original state
     */
    function resetButton($btn) {
        if (!$btn.hasClass('btn-loading')) {
            return;
        }
        
        var originalContent = $btn.data('original-content');
        
        if (originalContent) {
            $btn.html(originalContent);
        }
        
        $btn.removeClass('btn-loading');
        $btn.prop('disabled', false);
        $btn.css('min-width', '');
        
        $btn.removeData('original-content');
        $btn.removeData('original-width');
    }

    /**
     * Handle form submission
     */
    function handleFormSubmit(e) {
        var $form = $(this);
        var $submitBtn = $form.find('button[type="submit"]:focus, input[type="submit"]:focus');
        
        // If no focused submit button, find the one that was clicked
        if ($submitBtn.length === 0) {
            $submitBtn = $form.data('clicked-button');
        }
        
        // If still no button found, find the first submit button
        if (!$submitBtn || $submitBtn.length === 0) {
            $submitBtn = $form.find('button[type="submit"], input[type="submit"]').first();
        }
        
        if ($submitBtn && $submitBtn.length > 0 && !shouldExclude($submitBtn)) {
            setButtonLoading($submitBtn);
            
            // For forms with target="_blank", reset button after delay
            if ($form.attr('target') === '_blank') {
                setTimeout(function() {
                    resetButton($submitBtn);
                }, config.resetDelay);
            }
        }
        
        // Clear the clicked button data
        $form.removeData('clicked-button');
    }

    /**
     * Track which submit button was clicked
     */
    function trackClickedButton(e) {
        var $btn = $(this);
        var $form = $btn.closest('form');
        
        if ($form.length > 0) {
            $form.data('clicked-button', $btn);
        }
    }

    /**
     * Handle standalone buttons (not in forms)
     */
    function handleStandaloneButton(e) {
        var $btn = $(this);
        
        // Skip if button is inside a form
        if ($btn.closest('form').length > 0) {
            return;
        }
        
        // Skip if already loading or excluded
        if ($btn.hasClass('btn-loading') || shouldExclude($btn)) {
            return;
        }
        
        // Check if button has onclick that navigates or similar action
        var onclick = $btn.attr('onclick');
        if (onclick && (onclick.indexOf('location') !== -1 || onclick.indexOf('href') !== -1)) {
            setButtonLoading($btn);
        }
    }

    /**
     * Initialize button loading
     */
    function init() {
        // Handle form submissions
        $(document).on('submit', 'form', handleFormSubmit);
        
        // Track which button was clicked in forms with multiple submit buttons
        $(document).on('click', 'button[type="submit"], input[type="submit"]', trackClickedButton);
        
        // Handle standalone navigation buttons
        $(document).on('click', '.btn[onclick*="location"], .btn[onclick*="href"]', handleStandaloneButton);
        
        // Reset buttons when modal is hidden (to handle form resets in modals)
        $(document).on('hidden.bs.modal', '.modal', function() {
            $(this).find('.btn-loading').each(function() {
                resetButton($(this));
            });
        });
        
        // Handle page show event (for back button navigation)
        $(window).on('pageshow', function(event) {
            if (event.originalEvent.persisted) {
                // Page was loaded from cache (back button)
                $('.btn-loading').each(function() {
                    resetButton($(this));
                });
            }
        });
    }

    // Expose methods globally for manual control
    window.ButtonLoading = {
        setLoading: function(selector) {
            $(selector).each(function() {
                setButtonLoading($(this));
            });
        },
        reset: function(selector) {
            $(selector).each(function() {
                resetButton($(this));
            });
        },
        resetAll: function() {
            $('.btn-loading').each(function() {
                resetButton($(this));
            });
        },
        config: config
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        init();
    });

})(jQuery);

