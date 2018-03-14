<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    Review::insert($name, $message, $rating, 1, 0);
    header("Location: /whitehillmotors/reviews");
}

?>

<main>
    <section>
        <div class="text">
            <h1 class="text-head-center">Submit a Review!</h1>
            <p class="text-body-center">If you would like to get in touch, fill out the form below and we will get back to you as soon
                as we can!</p>
            <form action="" onsubmit="return submitForm()" id="form" method="post">

              <label for="name">Name:</label>
              <input type="text" id="name" name="name" placeholder="Your name..">

              <label for="rating">Rating:</label>
              <input type="number" id="rating" name="rating" placeholder="Your rating...">

              <label for="message">Message:</label>
              <textarea id="message" name="message" placeholder="Write something.." style="height:200px"></textarea>
              <br /><br />
              <input class="button" type="submit" name="submit" value="Submit">

            </form>
        </div>
    </section>
</main>

<script>
    function submitForm() {
        let name = document.forms["form"]["name"].value;
        let rating = document.forms["form"]["rating"].value;
        let message = document.forms["form"]["message"].value;

        if (name == '' || rating == '' || message == '') {
            alert("Please fill out all the fields.");
            return false;
        }

        if (rating < 0 || rating > 5) {
            alert("Rating must be a number between 0 and 5.");
            return false;
        }

        alert("Your review has been submitted. Our staff team will approve your review shortly.");
    }
</script>
