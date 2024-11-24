<?php
    $this->title = "Submit Feedback";
    
    $feedbackForm = null;
    if(isset($this->data["feedbackForm"])){
        $feedbackForm = $this->data["feedbackForm"];
    }

    $message = null;
    if(isset($this->data["message"])) {
        $message = $this->data["message"];
    }
?>

<script>
    function loadTitles(type) {
        fetch(`fetch_titles?type=${type}`)
            .then(response => response.json())
            .then(data => {
                const referenceSelect = document.getElementById("reference_id");
                referenceSelect.innerHTML = ""; // Clear existing options

                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.id;
                    option.textContent = item.title; // Display title instead of ID
                    referenceSelect.appendChild(option);
                });
            });
    }
</script>

<main id="feedback">
    <h1>Submit Feedback</h1>
    <form action="feedback" method="POST">
        <label for="type">Feedback Type:</label>
        <select name="type" id="type" onchange="loadTitles(this.value)" required>
            <option value="">-- Select Type --</option>
            <option value="product">Product</option>
            <option value="news">News</option>
        </select>

        <label for="reference_id">Select Title:</label>
        <select name="reference_id" id="reference_id" required>
            <!-- Options will be dynamically populated -->
        </select>

        <label for="comment">Comment:</label>
        <?php 
            if($feedbackForm != null) {
                echo "<textarea name='comment' id='comment' rows='4' required>{$feedbackForm->comment}</textarea>";
                if(isset($feedbackForm->errors["comment"])) {
                    echo "<span class='validation-error'>{$feedbackForm->errors["comment"]}</span>";
                }
            } else {
                echo "<textarea name='comment' id='comment' rows='4' required></textarea>";
            }
        ?>

        <button type="submit">Submit Feedback</button>
    </form>

    <script>
        window.onload = function () {
            <?php
                if($message != null) {
                    echo "alert('{$message}')";
                }
            ?>
        }
    </script>
</main>