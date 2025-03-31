document.addEventListener("DOMContentLoaded", function () {
  const questionsContainer = document.getElementById("questions-container");
  const addQuestionBtn = document.getElementById("add-question");
  const previewQuestions = document.getElementById("preview-questions");

  function createQuestionBlock(index) {
    const questionDiv = document.createElement("div");
    questionDiv.classList.add("mb-3", "question-block");
    questionDiv.innerHTML = `
      <label class="form-label">Enter Question ${index}:</label>
      <input type="text" class="form-control question-input" placeholder="Type your question here...">
      <select class="form-select question-type mt-2">
          <option value="Open" selected>Open-ended</option>
          <option value="Single">Single Choice</option>
          <option value="Multiple">Multiple Choice</option>
      </select>
      <div class="options-container mt-2"></div>
      <div class="button-group mt-2">
          <button class="btn btn-sm btn-warning add-option" style="display:none;">+ Add Option</button>
          <button class="btn btn-sm btn-danger delete-question">🗑 Delete Question</button>
      </div>
    `;
    questionsContainer.appendChild(questionDiv);
    updatePreview();
  }

  function updatePreview() {
    previewQuestions.innerHTML = "";
    const questions = document.querySelectorAll(".question-block");
    questions.forEach((block, idx) => {
      const questionText = block.querySelector(".question-input").value.trim() || `Question ${idx + 1}`;
      const type = block.querySelector(".question-type").value;
      const previewDiv = document.createElement("div");
      previewDiv.classList.add("mb-3");
      previewDiv.innerHTML = `<p class="fw-bold">${questionText} (${type})</p>`;
      if (type === "Single" || type === "Multiple") {
        const optionsDiv = document.createElement("div");
        block.querySelectorAll(".option-input").forEach(option => {
          if (option.value.trim() !== "") {
            const inputType = type === "Single" ? "radio" : "checkbox";
            optionsDiv.innerHTML += `<div><input type="${inputType}" name="question${idx}" class="me-2">${option.value.trim()}</div>`;
          }
        });
        previewDiv.appendChild(optionsDiv);
      } else if (type === "Open") {
          previewDiv.innerHTML += `<textarea class="form-control" placeholder="Your response..."></textarea>`;
      }
      previewQuestions.appendChild(previewDiv);
    });
  }

  addQuestionBtn.addEventListener("click", function () {
    createQuestionBlock(document.querySelectorAll(".question-block").length + 1);
  });

  questionsContainer.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-question")) {
      event.target.closest(".question-block").remove();
      updatePreview();
    }
    if (event.target.classList.contains("add-option")) {
      const optionsContainer = event.target.closest(".question-block").querySelector(".options-container");
      const optionInput = document.createElement("input");
      optionInput.type = "text";
      optionInput.classList.add("form-control", "option-input", "mt-2");
      optionInput.placeholder = `Option ${optionsContainer.children.length + 1}`;
      optionsContainer.appendChild(optionInput);
      updatePreview();
    }
  });

  questionsContainer.addEventListener("change", function (event) {
    if (event.target.classList.contains("question-type")) {
      const optionsContainer = event.target.parentElement.querySelector(".options-container");
      const addOptionBtn = event.target.parentElement.querySelector(".add-option");
      if (event.target.value === "Single" || event.target.value === "Multiple") {
        optionsContainer.innerHTML = `<input type="text" class="form-control option-input mt-2" placeholder="Option 1">`;
        addOptionBtn.style.display = "block";
      } else {
        optionsContainer.innerHTML = "";
        addOptionBtn.style.display = "none";
      }
      updatePreview();
    }
  });

  questionsContainer.addEventListener("input", function () {
    updatePreview();
  });
});

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

  console.log(JSON.stringify({ questions: questions }, null, 2));

  fetch("save-voting-questions.php", {
    method: "POST",
    headers: {"Content-Type" : "application/json" },
    body : JSON.stringify({ questions: questions })
  })
  .then(response => response.json())
  .then(data => {
    console.log("server response: ", data);
    if (data.success) {
      alert("questions saved successfully");
    }
    else {
      alert("error saving questions: " + data.error);
    }
  })
});

