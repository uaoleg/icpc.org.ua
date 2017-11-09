function appUserAdditionalGeneral() {

    // Activate datepicker
    $('#dateOfBirth').datepicker({
        format: DATE_FORMAT_DATEPICKER,
        weekStart: 1
    });
    $('#dateOfBirth').inputmask(DATE_FORMAT_INPUT_MASK);

}