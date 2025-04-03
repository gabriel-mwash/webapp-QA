document.addEventListener("DOMContentLoaded", function() {
  const questionsContainer = document.getElementById("questions-container");
  const addQuestionBtn = document.getElementById("add-question");
  const previewQuestions = document.getElementById("preview-questions");
  const launchVoteBtn = document.getElementById("launch-vote");

  // Initialize with one question
  createQuestionBlock(1);

  function createQuestionBlock(index) {
    const questionDiv = document.createElement("div");
    questionDiv.classList.add("mb-3", "question-block", "p-3", "border");
    questionDiv.innerHTML = `
      <label class="form-label">Question ${index}:</label>
      <input type="text" class="form-control question-input mb-2" placeholder="Type your question here..." required>
      <select class="form-select question-type mb-2">
        <option value="Open">Open-ended</option>
        <option value="Single">Single Choice</option>
        <option value="Multiple">Multiple Choice</option>
      </select>
      <div class="options-container mb-2"></div>
      <div class="button-group">
        <button class="btn btn-sm btn-success add-option" style="display:none;">+ Add Option</button>
        <button class="btn btn-sm btn-danger delete-question ms-2">Delete Question</button>
      </div>
    `;
    questionsContainer.appendChild(questionDiv);
    updatePreview();
  }

  function updatePreview() {
    previewQuestions.innerHTML = "";
    const questions = document.querySelectorAll(".question-block");
    
    if (questions.length === 0) {
      previewQuestions.innerHTML = '<div class="alert alert-info">No questions added yet</div>';
      return;
    }

    questions.forEach((block, idx) => {
      const questionText = block.querySelector(".question-input").value.trim() || `Question ${idx + 1}`;
      const type = block.querySelector(".question-type").value;
      const previewDiv = document.createElement("div");
      previewDiv.classList.add("mb-3", "p-3", "border");
      
      previewDiv.innerHTML = `
        <p class="fw-bold mb-2">${questionText} <span class="badge bg-secondary">${type}</span></p>
      `;
      
      if (type === "Single" || type === "Multiple") {
        const optionsDiv = document.createElement("div");
        const options = block.querySelectorAll(".option-input");
        
        if (options.length === 0) {
          optionsDiv.innerHTML = '<div class="text-danger">No options added</div>';
        } else {
          options.forEach(option => {
            const inputType = type === "Single" ? "radio" : "checkbox";
            optionsDiv.innerHTML += `
              <div class="form-check">
                <input class="form-check-input" type="${inputType}" name="question${idx}">
                <label class="form-check-label">${option.value.trim() || "Empty option"}</label>
              </div>
            `;
          });
        }
        previewDiv.appendChild(optionsDiv);
      } else {
        previewDiv.innerHTML += `
          <textarea class="form-control" rows="2" placeholder="Your response..." disabled></textarea>
        `;
      }
      previewQuestions.appendChild(previewDiv);
    });
  }

  addQuestionBtn.addEventListener("click", function() {
    createQuestionBlock(document.querySelectorAll(".question-block").length + 1);
  });

  questionsContainer.addEventListener("click", function(e) {
    if (e.target.classList.contains("delete-question")) {
      if (document.querySelectorAll(".question-block").length > 1) {
        e.target.closest(".question-block").remove();
        updatePreview();
      } else {
        alert("You must have at least one question");
      }
    }
    
    if (e.target.classList.contains("add-option")) {
      const optionsContainer = e.target.closest(".question-block").querySelector(".options-container");
      const optionInput = document.createElement("input");
      optionInput.type = "text";
      optionInput.classList.add("form-control", "option-input", "mt-2");
      optionInput.placeholder = `Option ${optionsContainer.children.length + 1}`;
      optionInput.required = true;
      optionsContainer.appendChild(optionInput);
      updatePreview();
    }
  });

  questionsContainer.addEventListener("change", function(e) {
    if (e.target.classList.contains("question-type")) {
      const optionsContainer = e.target.closest(".question-block").querySelector(".options-container");
      const addOptionBtn = e.target.closest(".question-block").querySelector(".add-option");
      
      if (e.target.value === "Single" || e.target.value === "Multiple") {
        optionsContainer.innerHTML = '';
        const optionInput = document.createElement("input");
        optionInput.type = "text";
        optionInput.classList.add("form-control", "option-input", "mb-2");
        optionInput.placeholder = "Option 1";
        optionInput.required = true;
        optionsContainer.appendChild(optionInput);
        addOptionBtn.style.display = "inline-block";
      } else {
        optionsContainer.innerHTML = '';
        addOptionBtn.style.display = "none";
      }
      updatePreview();
    }
  });

  questionsContainer.addEventListener("input", function() {
    updatePreview();
  });

  launchVoteBtn.addEventListener("click", async function() {
    const questions = [];
    let isValid = true;
    
    // Validate all questions
    document.querySelectorAll(".question-block").forEach((block, index) => {
      const questionText = block.querySelector(".question-input").value.trim();
      const questionType = block.querySelector(".question-type").value;
      
      if (!questionText) {
        isValid = false;
        block.querySelector(".question-input").classList.add("is-invalid");
      } else {
        block.querySelector(".question-input").classList.remove("is-invalid");
      }
      
      const questionData = {
        question_text: questionText,
        question_type: questionType,
        options: []
      };
      
      if (questionType === "Single" || questionType === "Multiple") {
        block.querySelectorAll(".option-input").forEach(option => {
          const optionText = option.value.trim();
          if (optionText) {
            questionData.options.push(optionText);
          }
        });
        
        if (questionData.options.length === 0) {
          isValid = false;
          block.querySelector(".options-container").classList.add("border-danger");
        } else {
          block.querySelector(".options-container").classList.remove("border-danger");
        }
      }
      
      questions.push(questionData);
    });
    
    if (!isValid) {
      alert("Please fill all required fields and ensure choice questions have options");
      return;
    }
    
    try {
      const response = await fetch("save-voting-questions.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ questions })
      });
      
      const result = await response.json();
      
      if (result.success) {
        alert("Voting questions saved successfully!");
        // Optional: Reset form or redirect
        // questionsContainer.innerHTML = '';
        // createQuestionBlock(1);
      } else {
        throw new Error(result.error || "Failed to save questions");
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Error: " + error.message);
    }
  });
});
