document.getElementById("launch-vote").addEventListener("click", function () {
  const questions = [];
  document.querySelectorAll(".question-block").forEach(block => {
    const questionText = block.querySelector(".question-input").value.trim();
    const questionType = block.querySelector(".question-type").value;
    
    const questionData = 
      { 
        question_text: questionText, 
        question_type: questionType, 
        options: [] 
      };

    if (questionType === "Single" || questionType === "Multiple") {
      block.querySelectorAll(".option-input").forEach(option => {
        if (option.value.trim() !== "") {
          questionData.options.push(option.value.trim());
        }
      });
    }
    questions.push(questionData);
  });

  fetch("save-voting-questions.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ questions: questions })
  }).then(response => response.json())
  .then(data => {
    if (data.success) {
      alert("Questions saved successfully!");
    } 
    else {
      alert("Error saving questions.");
    }
  });
});

