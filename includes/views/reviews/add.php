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
              <input class="button" type="submit" value="Submit">

            </form>
        </div>
    </section>
</main>

<script>
    function submitForm() {
        name = document.forms["form"]["name"].value;
        email = document.forms["form"]["email"].value;
        subject = document.forms["form"]["subject"].value;

        if (name == '' || subject == '' || email == '') {
            alert("Please fill out all the fields.");
            return false;
        }

        // Now to check the email address to make sure it is valid
        if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) {
            alert("You have entered an invalid email address! Example: jane-doe@gmail.com");
            return false;
        }

        alert("Your message has been sent! We will get back to you as soon as possible.");
    }
</script>
