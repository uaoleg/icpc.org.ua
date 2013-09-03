/**
 * Translate function
 *
 * @param {String} category
 * @param {String} text
 * @param {Object}  params
 * @return {String}
 */
function _t(category, text, params)
{
    // Try to get translation for the text
    if ((typeof translations !== 'undefined') &&
        (typeof translations[category] !== undefined) &&
        (typeof translations[category][appLanguage] !== undefined) &&
        (typeof translations[category][appLanguage][text] !== undefined) &&
        (typeof translations[category][appLanguage][text].translation !== undefined) &&
        (translations[category][appLanguage][text].translation !== '')) {
        text = translations[category][appLanguage][text].translation;
    }
    
    // Replace params
    if (params) {
        $.each(params, function(key, value) {
            text = text.split(key).join(value)
        });
    }

    return text;
}