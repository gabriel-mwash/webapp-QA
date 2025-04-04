const chartInstances = [];
let openEndedContainers = []; // Track open-ended containers separately
let updateInterval;
let isFirstLoad = true;

function fetchVoteResults() {
  fetch('get_vote_results.php')
    .then(response => response.json())
    .then(data => {
      if (data.length === 0) {
        const chartsContainer = document.getElementById("charts");
        chartsContainer.innerHTML = `
          <div class="no-votes-message">
          <i class=bi bi-info-circle"></i>
          No votes have been recorded yet. Refresh page !
          </div>
          `;
        return;
      }
      // Separate open-ended from other questions
      const chartQuestions = data.filter(q => q.query_type !== 'Open');
      const openQuestions = data.filter(q => q.query_type === 'Open');
      
      // Clear existing open-ended containers on each refresh
      openEndedContainers.forEach(container => {
        if (container && container.parentNode) {
          container.parentNode.removeChild(container);
        }
      });
      openEndedContainers = [];
      
      // Render charts first
      renderCharts(chartQuestions, false);
      
      // Then render open-ended questions
      renderCharts(openQuestions, true);
      
      if (isFirstLoad) {
        startAutoRefresh();
        isFirstLoad = false;
      }
    })
    .catch(error => {
      console.error('Error fetching vote data:', error);
      setTimeout(fetchVoteResults, 5000);
    });
}

function renderCharts(responseData, isOpenEnded) {
  const chartsContainer = document.getElementById('charts');
  
  if (isFirstLoad && !isOpenEnded) {
    // Clear only on first load for non-open-ended questions
    chartsContainer.innerHTML = '';
  }

  responseData.forEach((data, index) => {
    let chartContainer, chartWrapper;
    
    if (isOpenEnded) {
      // Create new container for open-ended questions
      chartContainer = document.createElement('div');
      chartContainer.classList.add('chart-container');
      
      const questionTitle = document.createElement('div');
      questionTitle.classList.add('question-title');
      questionTitle.textContent = data.question;
      chartContainer.appendChild(questionTitle);

      chartWrapper = document.createElement('div');
      chartWrapper.classList.add('chart-wrapper');
      chartContainer.appendChild(chartWrapper);

      // Append to container and track it
      chartsContainer.appendChild(chartContainer);
      openEndedContainers.push(chartContainer);
    } 
    else if (isFirstLoad) {
      // Create new container for regular questions on first load
      chartContainer = document.createElement('div');
      chartContainer.classList.add('chart-container');
      
      const questionTitle = document.createElement('div');
      questionTitle.classList.add('question-title');
      questionTitle.textContent = data.question;
      chartContainer.appendChild(questionTitle);

      chartWrapper = document.createElement('div');
      chartWrapper.classList.add('chart-wrapper');
      chartContainer.appendChild(chartWrapper);

      chartsContainer.appendChild(chartContainer);
    } 
    else {
      // Update existing container for regular questions
      chartContainer = chartsContainer.children[index];
      chartWrapper = chartContainer.querySelector('.chart-wrapper');
      chartContainer.querySelector('.question-title').textContent = data.question;
    }

    // Clear previous content
    if (chartWrapper) {
      chartWrapper.innerHTML = '';

      if (!isOpenEnded && (data.query_type === 'Multiple' || data.query_type === 'Single')) {
        const canvas = document.createElement('canvas');
        chartWrapper.appendChild(canvas);

        if (chartInstances[index]) {
          chartInstances[index].destroy();
        }

        const chartData = {
          labels: data.responses.options.map(option => option.option_text),
          datasets: [{
            label: data.question,
            data: data.responses.options.map(option => option.vote_count),
            backgroundColor: [
              '#228B22', '#FFD700', '#DC143C', '#4682B4',
              '#9400D3', '#FF6347', '#20B2AA', '#FF8C00'
            ],
            borderColor: '#000',
            borderWidth: 1
          }]
        };

        const chartOptions = {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                padding: 20,
                boxWidth: 20,
                generateLabels: function(chart) {
                  const data = chart.data;
                  if (data.labels.length && data.datasets.length) {
                    return data.labels.map((label, i) => ({
                      text: label,
                      fillStyle: data.datasets[0].backgroundColor[i],
                      hidden: !chart.getDataVisibility(i),
                      lineWidth: 0,
                      strokeStyle: data.datasets[0].borderColor,
                      lineDash: []
                    }));
                  }
                  return [];
                }
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return context.label + ': ' + context.raw + ' votes';
                }
              }
            }
          }
        };

        if (data.query_type === 'Multiple') {
          chartOptions.scales = {
            y: {
              beginAtZero: true,
              ticks: {
                precision: 0
              }
            }
          };
        }

        const chart = new Chart(canvas, {
          type: data.query_type === 'Multiple' ? 'bar' : 'pie',
          data: chartData,
          options: chartOptions
        });
        
        chartInstances[index] = chart;
      } 
      else if (isOpenEnded) {
        const listContainer = document.createElement('ul');
        listContainer.classList.add('response-list');

        const filteredResponses = data.responses.open_responses
          .map(response => response.trim())
          .filter(response => response.length > 0);

        if (filteredResponses.length > 0) {
          filteredResponses.forEach(response => {
            const listItem = document.createElement('li');
            listItem.textContent = response;
            listContainer.appendChild(listItem);
          });
        } else {
          const emptyMessage = document.createElement('li');
          emptyMessage.textContent = 'No responses yet';
          emptyMessage.style.backgroundColor = '#f0f0f0';
          emptyMessage.style.color = '#666';
          listContainer.appendChild(emptyMessage);
        }

        chartWrapper.appendChild(listContainer);
        chartWrapper.style.minHeight = '0';
        chartContainer.style.minHeight = 'auto';
      }
    }
  });
}

function startAutoRefresh() {
  updateInterval = setInterval(fetchVoteResults, 20000);
}

window.addEventListener('DOMContentLoaded', fetchVoteResults);
window.addEventListener('beforeunload', () => {
  clearInterval(updateInterval);
  chartInstances.forEach(chart => chart.destroy());
});
