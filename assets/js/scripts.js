let batch = 0;


function fetchQuestions() {

  let response = fetch(`http://localhost/fetch_questions.php?batch=${batch}`);

  response.then(function(res) {
    if(res.ok) {
      return res.json();
    }
    else {
      throw new Error("Network response was not ok");
    }
  })


  .then(function(data) {

    let container = document.querySelector(".query-container");
    if (data.length === 0 && batch === 0) {
      let noQuestionPad = document.createElement("div");
      noQuestionPad.classList.add("no-question", "fade-in");
      noQuestionPad.innerHTML = `
      <div class="no-question">
          <p class="query-text" style="font-family: 'Fredoka One', 
            serif;font-size: 25px;text-align: center;padding: 0.5rem; margin: 0.5rem 0 0.5rem 0;"
            >NO QUESTIONS YET <br>
            NURTURING A NEW BREED OF LEADERS <br> IN AFRICA
            </p>
      </div>
     `;

      container.appendChild(noQuestionPad);
      document.getElementById("LoadMore").style.display="none";
      return;
    }

    // console.log(data[0]);

    data.forEach(function(question) {

      let queryPad = document.createElement("div");
      queryPad.classList.add("container", "query-pad", "fade-in");

      queryPad.innerHTML = `
      <div class="row">
          <div class="col-md-12 d-flex query-section">
              <div class="query-container" style="margin: 0px;">
                  <p class="query-text" style="font-family: 'Fredoka One', 
                    serif;font-size: 25px;text-align: center;margin: 0.5rem 0 0.5rem 0;"
                    >${question.question}</p>
              </div>
              <div class="flex-wrap name-query" style="margin-bottom: 10px;">
                  <div class="text-center name-qw" style="width: fit-content;">
                    <span style="border-radius: 5px;margin-right: 3px;margin-left: 3px;">${question.name}</span>
                  </div>
                  <div class="text-center" style="background: #94d82d;border-radius: 5px;margin-left: 5px;padding: 3px;">
                    <span class="camp-qw">${question.institute}</span>
                  </div>
              </div>
          </div>
      </div>
      `;
      
      container.appendChild(queryPad);
    });

    if (data.length < 7) {
      document.getElementById("LoadMore").style.display="none";
    }
    batch++;
  })
  .catch(function(error) {
    console.error("there was a problem with the fetch operation: ", error);
  })
}

fetchQuestions();

document.getElementById("LoadMore" ).addEventListener("click", fetchQuestions);

