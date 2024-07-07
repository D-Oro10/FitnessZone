<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitnessZone</title>

    <!-- For Favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml" />

    <link rel="stylesheet" href="styles.css" />

    <!-- For Google Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Catamaran:wght@600;700;800;900&family=Rubik:wght@400;500;800&display=swap"
      rel="stylesheet"
    />
  </head>

  <body id="top">
    <!-- For Header Part -->

    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GymRat</title>

    <!-- For Favicon -->
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml" />

    <link rel="stylesheet" href="style.css" />

    <!-- For Google Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Catamaran:wght@600;700;800;900&family=Rubik:wght@400;500;800&display=swap"
      rel="stylesheet"
    />

  </head>

  <body id="top">
    <!-- For Header Part -->

    <header class="header" data-header>
      <div class="container">
        <a href="home.html" class="logo">
          <img src="images/Logo-removebg-preview (1).png" alt="" />
          <span class="span">FitnessZone</span>
        </a>

        <nav class="navbar" data-navbar>
          <button
            class="nav-close-btn"
            aria-label="close menu"
            data-nav-toggler
          >
            <ion-icon name="close-sharp" aria-hidden="true"></ion-icon>
          </button>

          <ul class="navbar-list">
            <li>
              <a href="home.html" class="navbar-link active" data-nav-link>Home</a>
            </li>

            <li>
              <a href="#about" class="navbar-link" data-nav-link>About Us</a>
            </li>

            <li>
              <a href="#class" class="navbar-link" data-nav-link>Classes</a>
            </li>

            <li>
              <a href="Update_Info.php" class="navbar-link" data-nav-link
                >Edit Profile</a>
            </li>

            <li>
                <a href="index.php" class="navbar-link" data-nav-link>Logout</a>
            </li>
          </ul>
        </nav>

        <a href="appointment.php" class="btn btn-secondary">Set an Appointment</a>

        <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
        </button>
      </div>
    </header>
    <section
          class="section hero bg-dark has-after has-bg-image"
          id="home"
          aria-label="hero"
          data-section
          style="background-image: url('images/hero-bg.png')"
    >
    <!-- Login Form -->
    <main>
        <div class="form-container" id="AppointmentForm" >
            <form class="box" action="formtodb.php" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <h2>Set Appointment</h2>
                <label for="MemberID">MemberID</label>
                <input type="text" id="appointmentid" name="MemberID" placeholder="Enter MemberID">

                <label for="selectClass">Choose a class:</label>
                <select id="selectClass" name="ClassID">
                <option value="">Select a Class:</option>
                <option value="MB1">Mind and Body Class</option>
                <option value="HIC1">Hit Class</option>
                <option value="CC1">Cycling</option>
                <option value="CD2">Cardio</option>
                <option value="SC3">Strength and Conditioning</option>
                <option value="DD1">Dance</option>
                </select>

                <label for="CoachID">Coach ID</label>
                <select id="selectCoach" name="CoachID">
                <option value="">Select a Coach:</option>
                <option value="5001">Nicolas Rivera</option>
                <option value="5002">Abby Lorenzo</option>
                <option value="5003">Darren Cruz</option>
                <option value="5004">Aaron Santos</option>
                <option value="5005">Miguel Gonzaga</option>
                </select>

                <label for="dateInput">Select a date:</label>
                <input type="date" id="dateInput" name="dateInput">
                                
                <button type="submit">Set Appointment</button>
            </form>
        </div>
        <script>
        // JavaScript function to show the appointment form
            function showAppointmentForm() {
                // Get the appointment form element
                var form = document.getElementById("AppointmentForm");
                // Display the form by changing its style
                form.style.display = "block";
                }
        </script>
    </main>

    <!-- For Footer Part -->
    <footer class="footer">
      <div
        class="section footer-top bg-dark has-bg-image"
        style="background-image: url('images/footer-bg.png')"
      >
        <div class="container">
          <div class="footer-brand">
            <a href="#" class="logo">
              <!--<ion-icon name="barbell-sharp" aria-hidden="true"></ion-icon>-->
              <img src="images/Logo-removebg-preview (1).png" alt="" />
              <span class="span">FitnessZone</span>
            </a>

            <p class="footer-brand-text">
              
            </p>

            <div class="wrapper">
              <img
                src="images/footer-clock.png"
                width="34"
                height="34"
                loading="lazy"
                alt="Clock"
              />

              <ul class="footer-brand-list">
                <li>
                  <p class="footer-brand-title">Monday - Friday</p>

                  <p>6:00AM - 10:00PM</p>
                </li>

                <li>
                  <p class="footer-brand-title">Saturday - Sunday</p>

                  <p>6:00AM - 5:00PM</p>
                </li>
              </ul>
            </div>
          </div>

          <ul class="footer-list">
            <li>
              <p class="footer-list-title has-before">Our Links</p>
            </li>

            <li>
              <a href="#" class="footer-link">Home</a>
            </li>

            <li>
              <a href="#" class="footer-link">About Us</a>
            </li>

            <li>
              <a href="#" class="footer-link">Classes</a>
            </li>

            <li>
              <a href="#" class="footer-link">Blog</a>
            </li>

            <li>
              <a href="tel:09357394500" class="footer-link">Contact Us</a>
            </li>
          </ul>

          <ul class="footer-list">
            <li>
              <p class="footer-list-title has-before">Contact Us</p>
            </li>

            <li class="footer-list-item">
              <div class="icon">
                <ion-icon name="location" aria-hidden="true"></ion-icon>
              </div>

              <address class="address footer-link">
                Baranggay Bigay, Sitio Kuha, Ubos Biyaya, 123 Change BF
              </address>
            </li>

            <li class="footer-list-item">
              <div class="icon">
                <ion-icon name="call" aria-hidden="true"></ion-icon>
              </div>

              <div>
                <a href="tel:09357394500" class="footer-link">09272303716</a>

                <a href="tel:+82486-765" class="footer-link">+82486-765</a>
              </div>
            </li>

            <li class="footer-list-item">
              <div class="icon">
                <ion-icon name="mail" aria-hidden="true"></ion-icon>
              </div>

              <div>
                <a href="mailto:russel.dlv02@gmail.com" class="footer-link"
                  >info@gymrat.com</a
                >

                <a href="mailto:russel.dlv02@gmail.com" class="footer-link"
                  >services@gymrat.com</a
                >
              </div>
            </li>
          </ul>

          <ul class="footer-list">
            <li>
              <p class="footer-list-title has-before">Our Newsletter</p>
            </li>

            <li>
              <form action="" class="footer-form">
                <input
                  type="email"
                  name="email_address"
                  aria-label="email"
                  placeholder="Email Address"
                  required
                  class="input-field"
                />

                <button
                  type="submit"
                  class="btn btn-primary"
                  aria-label="Submit"
                >
                  <ion-icon
                    name="chevron-forward-sharp"
                    aria-hidden="true"
                  ></ion-icon>
                </button>
              </form>
            </li>

            <li>
              <ul class="social-list">
                <li>
                  <a
                    href="https://www.facebook.com/fitnesszoneph"
                    class="social-link"
                  >
                    <ion-icon name="logo-facebook"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="social-link">
                    <ion-icon name="logo-instagram"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="social-link">
                    <ion-icon name="logo-twitter"></ion-icon>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom">
        <div class="container">
          <p class="copyright">
            &copy; 2023 FitZone. All Rights Reserved By
            <a href="#" class="copyright-link">FitZone.</a>
          </p>

          <ul class="footer-bottom-list">
            <li>
              <a href="#" class="footer-bottom-link has-before"
                >Privacy Policy</a
              >
            </li>

            <li>
              <a href="#" class="footer-bottom-link has-before"
                >Terms & Condition</a
              >
            </li>
          </ul>
        </div>
      </div>
    </footer>

    <!-- For Back 2 Top  -->

    <a
      href="#top"
      class="back-top-btn"
      aria-label="back to top"
      data-back-top-btn
    >
      <ion-icon name="caret-up-sharp" aria-hidden="true"></ion-icon>
    </a>

    <script src="script.js" defer></script>

    <!-- For Scroll Reveal -->
    <script src="script.js0.js"></script>

    <!-- For Ionicon Link -->
    <script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
  </body>
</html>
