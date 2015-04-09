function appStaffTeamImport(options)
{
   $(".teams").hide();
   $(".btn-save").hide();

   $('.btn-load').on('click', function() {
      var $this = $(this),
         $form = $this.closest('.form');

      $this.prop('disabled', true);

      $.ajax({
         url: app.baseUrl + '/staff/team/postTeams',
         data: {
            email: $('[name=email]').val(),
            password: $('[name=password]').val()
         },
         success: function (response) {
            if (response.errors) {
               var place = $("#formerrors");
               place.html("");
               $.each(response.errors, function(key, value) {
                  var html = '<div class="alert alert-danger text-center">' + value+ '</div>';
                  place.append(html);
               });
               $this.prop('disabled', false);
            } else {
               $list = $form.find('[name=team]');
               $list.html('');

               $.each(response.teams, function(key, value) {
                  var html = '<option value="' + value.id + '">' + value.title + '</option>';
                  $list.append(html);
               });

               $(".teams").show();
               $(".btn-save").show();
               $(".btn-load").hide();

               $('.auth input').prop('disabled', true);
               $this.prop('disabled', true);
            }
         }
      });
   });

   $('.btn-save').on('click', function() {
      var $this = $(this),
      $form = $this.closest('.form');

      $this.prop('disabled', true);

      $.ajax({
         url: app.baseUrl + '/staff/team/postImport',
         data: {
            team:             $('[name=team]').val(),
            email:            $('[name=email]').val(),
            password:         $('[name=password]').val()
         },
         success: function(response) {
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