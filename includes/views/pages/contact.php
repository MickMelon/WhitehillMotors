<main>
    <section class="small"><h3><i class="fa fa-phone" aria-hidden="true"></i>Call us now on 01307 461234</h3></section>

    <section>
        <div class="text">
            <h1 class="text-head-center">Give us a shout!</h1>
            <p class="text-body-center">If you would like to get in touch, fill out the form below and we will get back to you as soon
                as we can!</p>
            <form action="" onsubmit="return submitForm()" id="form" method="post">

              <label for="fname">Name:</label>
              <input type="text" id="name" name="name" placeholder="Your name..">

              <label for="lname">Email:</label>
              <input type="text" id="email" name="email" placeholder="Your last name..">

              <label for="subject">Message:</label>
              <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
              <br /><br />
              <input class="button" type="submit" value="Submit">

            </form>
        </div>
    </section>

    <section id="map" style="height: 400px;"></section>

    <section class="small">20 Market Place, Forfar, DD8 3BX</section>


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
