$(document).ready(function() {
  // Fetch questions using AJAX (this part is fine)
  $.ajax({
    url: './fetch-voting-queries.php',
    method: 'GET',
    success: function(response) {
      var questions = JSON.parse(response);
      
      if (questions.error) {
        alert(questions.error);
        return;
      }
      questions.forEach(function(question) {
        var questionHtml = '<div class="question-pad">';
        questionHtml += '<h3>' + question.text + '</h3>';

        if (question.type === 'single') {
          question.options.forEach(function(option) {
            questionHtml += '<label><input type="radio" name="vote[' 
            + question.id + ']" value="' + option.id + '"> ' + option.text + '</label>';
          });
        } 
        else if (question.type === 'Multiple') {
          question.options.forEach(function(option) {
            questionHtml += 
              '<label><input type="checkbox" name="vote[' 
              + question.id + '][]" value="' + option.id + '"> ' 
              + option.text + '</label>';
          });
        } 
        else if (question.type === 'open') {
          questionHtml += 
            '<textarea name="vote[' +
            question.id + ']" placeholder="Your answer..."></textarea>';
        }
        questionHtml += '</div>';
        $('#questions-container').append(questionHtml);
      });
    },
    error: function() {
      alert('There was an error fetching the questions.');
    }
  });

  // Handle submit vote
  $("#submit-vote").click(function(e) {
    e.preventDefault();
    
    // Collect form data
    var formData = new FormData($("#vote-form")[0]);
    console.log("Form data being sent: ");
    for (var pair of formData.entries()) {
      console.log(pair[0] + ": " + pair[1]);
    }
    
    $.ajax({
      url: 'submit_vote.php',
      method: 'POST',
      data: formData,
      processData: false,  // Important for FormData
      contentType: false,  // Important for FormData
      success: function(response) {
            try {
                var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (jsonResponse.success) {
                    alert(jsonResponse.success);
                    // Optional: Reset form after success
                    $("#vote-form")[0].reset();
                } else if (jsonResponse.error) {
                    alert("Error: " + jsonResponse.error);
                }
            } catch (e) {
                console.error("Failed to parse JSON:", e, "Response:", response);
                alert("Unexpected server response");
            }
        },
      error: function(xhr, status, error) {
        console.error("AJAX error:", status, error);
        alert('There was an error submitting your vote.');
      }
    });
  });
});
