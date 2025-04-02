<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vote Results</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
  }
  .chart-container {
      width: 500px;
      margin: 20px auto;
      margin-bottom: 40px;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  h2 {
      text-align: center;
      color: #333;
  }
  .response-list {
      list-style-type: none;
      padding: 0;
      margin-top: 10px;
  }
  .response-list li {
      background-color: #e0f7fa;
      margin: 5px 0;
      padding: 10px;
      border-radius: 4px;
  }
  .question-title {
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
      font-size: 18px;
  }
</style>
</head>
<body>

<h2>Voting Results</h2>

<div id="charts"></div> <!-- The charts will be dynamically inserted here -->

<script>
    // Function to fetch results from the backend and render the charts
    function fetchVoteResults() {
        fetch('get_vote_results.php')  // Replace with the actual backend script URL
            .then(response => response.json())
            .then(data => renderCharts(data))
            .catch(error => {
                console.error('Error fetching vote data:', error);
            });
    }
    // Function to render charts dynamically based on the fetched data
    function renderCharts(responseData) {
        const chartsContainer = document.getElementById('charts');
        chartsContainer.innerHTML = ''; // Clear the container before rendering new charts

        responseData.forEach((data) => {
            const chartContainer = document.createElement('div');
            chartContainer.classList.add('chart-container');
            
            // Display the question text
            const questionTitle = document.createElement('div');
            questionTitle.classList.add('question-title');
            questionTitle.textContent = data.question;
            chartContainer.appendChild(questionTitle);

            const canvas = document.createElement('canvas');
            chartContainer.appendChild(canvas);

            const chartData = {
                labels: [],
                datasets: [{
                    label: data.question,
                    data: [],
                    backgroundColor: [], // Colors for each option
                    borderColor: '#000', // Black border for all charts
                    borderWidth: 1
                }]
            };

            const chartOptions = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' votes'; // Show votes on hover
                            }
                        }
                    }
                }
            };

            // Predefined color palette (accessible colors)
            const colors = [
                '#6c5b7b', '#c06c84', '#f67280', '#f8b195', '#355c7d', '#6a4c93', '#c3b299', '#f5a623'
            ];

            if (data.query_type === 'Multiple' || data.query_type === 'single') {
                // For multiple or single choice question type, use bar or pie chart
                chartData.labels = data.responses.options.map(option => option.option_text);
                chartData.datasets[0].data = data.responses.options.map(option => option.vote_count);
                chartData.datasets[0].backgroundColor = data.responses.options.map((_, index) => colors[index % colors.length]); // Use predefined colors

                if (data.query_type === 'Multiple') {
                    // Bar chart for Multiple choice
                    new Chart(canvas, {
                        type: 'bar',
                        data: chartData,
                        options: chartOptions
                    });
                } else if (data.query_type === 'single') {
                    // Pie chart for Single choice
                    new Chart(canvas, {
                        type: 'pie',
                        data: chartData,
                        options: chartOptions
                    });
                }
            } else if (data.query_type === 'open') {
                // For open-ended questions, display the responses as a list
                const listContainer = document.createElement('ul');
                listContainer.classList.add('response-list');
                
                data.responses.open_responses.forEach(response => {
                    const listItem = document.createElement('li');
                    listItem.textContent = response;
                    listContainer.appendChild(listItem);
                });

                chartContainer.appendChild(listContainer);
            }

            chartsContainer.appendChild(chartContainer);
        });
    }

    // Fetch and render the vote results when the page loads
    window.onload = fetchVoteResults;
</script>

</body>
</html>

