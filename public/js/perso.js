
$(document).ready(function(){
	//affichage formulaire de contact
	$('#buttonShowForm').on('click', function () {
		$(this).addClass('hidden');
		$('#contact-container').removeClass('extraMargin');
		$('#linkMaskForm').removeClass('hidden');
		$('#buttonMaskForm').removeClass('hidden');
	});
	$('#buttonMaskForm').on('click',function() {
		$(this).addClass('hidden');
		$('#linkMaskForm').addClass('hidden');
		$('#contact-container').addClass('extraMargin');
		$('#linkShowForm').removeClass('hidden');
		$('#buttonShowForm').removeClass('hidden');
	});

	$('#caret').on('click', function(){
		if($('#caret-up').hasClass('hidden')){
			$('#caret-up').removeClass('hidden');
			$('#caret-down').addClass('hidden');
		}
		else{
			$('#caret-up').addClass('hidden');
			$('#caret-down').removeClass('hidden');	
		}

	});
	
			
	$('#form-ajax').submit(function(e) { //Validation du formulaire
		e.preventDefault();
		console.log("bazinga");

		$.ajax({
			type: "POST",
			url: "/ajax",
			data: $("#form-ajax").serialize(), //cibler le formulaire de contact// Assemble tous les champs du formulaire pour envoyer le contenu
			dataType: 'json',


			success: function(json) { // Affiche une alerte Bootstrap
				console.log(json);	
				console.log("bazinga2");
				$("#reponse").removeClass();
				
				if(json.success){
					$("#reponse").addClass("alert alert-success").html("Le message est bien envoyé");	
				}
				else{
					var impErrors = '';

					$(json.erreurs).each(function(i, error){
						console.log("bazinga3")
						console.log(error);
					 	if (i!=0){
							impErrors += '<br>';
						}
						impErrors += error;
					});

					$("#reponse").addClass("alert alert-danger").html(impErrors);
						 
					console.log(impErrors);	
				}
			},

			error: function(response, status, error) {
                console.log('=== ajax error ===');
                console.log('-> error :');
                console.log(error);
			}

		});
	});

});