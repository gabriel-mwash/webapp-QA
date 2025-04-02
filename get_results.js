async function fetchResults() {
    try {
        let response = await fetch("get_vote_results.php");
        let data = await response.json();
        
        console.log("Fetched Results:", data); // Logs data to console

        // Now, process and display the data in the UI
    } catch (error) {
        console.error("Error fetching results:", error);
    }
}

fetchResults(); // Call the function to load data

