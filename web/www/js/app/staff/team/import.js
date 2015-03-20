function appStaffTeamImport(options)
{
   $('.btn-save').on('click', function() {
      var $this = $(this),
         $form = $this.closest('.form');
      $this.prop('disabled', true);

      $.ajax({
         url: app.baseUrl + '/staff/team/postImport',
         data: {
            url:              $('[name=url]').val(),
            email:            $('[name=email]').val(),
            password:         $('[name=password]').val()
         },
         success: function(response) {
            console.debug(response);
            if (response.errors) {

               var place = $("#formerrors");
               place.html("");
               $.each(response.errors, function(key, value) {
                  var html = '<div class="alert alert-danger text-center">' + value+ '</div>';
                  place.append(html);
               });

            } else {
               if (response.teamId !== '' && response.teamId !== undefined) {
                  location.href = app.baseUrl + '/team/view/id/' + response.teamId;
               }
            }
            $this.prop('disabled', false);
         }
      });

   });
}