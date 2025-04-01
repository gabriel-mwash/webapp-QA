$(document).ready(function() {
  // Fetch questions using AJAX
  $.ajax({
    url: './fetch-voting-queries.php', // The PHP file to fetch the questions
    method: 'GET',
    success: function(response) {
      var questions = JSON.parse(response); // Parse the response into an array
      
      if (questions.error) {
        alert(questions.error); // Show error if no questions are found
        return;
      }
      questions.forEach(function(question) {
        var questionHtml = '<div class="question-pad">';
        questionHtml += '<h3>' + question.text + '</h3>'; // Display question text

        // Handle options based on question type
        if (question.type === 'single') {
          question.options.forEach(function(option) {
            questionHtml += '<label><input type="radio" name="vote[' 
            + question.id + ']" value="' + option.id + '"> ' + option.text + '</label>';
            });
        } 
        else if (question.type === 'Multiple') {
          // Multiple choice (checkboxes)
          question.options.forEach(function(option) {
            questionHtml += '<label><input type="checkbox" name="vote[' + question.id + '][]" value="' + option.id + '"> ' + option.text + '</label>';
            });
        } 
        else if (question.type === 'open') {
          // Open-ended (text area)
          questionHtml += '<textarea name="vote[' + question.id + ']" placeholder="Your answer..."></textarea>';
        }
        questionHtml += '</div>'; // Close question pad
        $('#questions-container').append(questionHtml); // Append to the container
      });
    },
    error: function() {
        alert('There was an error fetching the questions.');
    }
  });
  // Handle submit vote
  $('#submit-vote').click(function() {
    var formData = $('form').serialize(); // Collect all form data
    console.log(formData);
    $.ajax({
      url: 'submit_vote.php', // URL to handle the vote submission (you'll create this file)
      method: 'POST',
      data: formData,
      contentType: "application/x-www-form-urlencoded",
      success: function(response) {
        alert('Your vote has been submitted!');
      },
      error: function() {
        alert('There was an error submitting your vote.');
      }
    });
  });
});
