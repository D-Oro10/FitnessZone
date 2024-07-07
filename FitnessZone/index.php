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
        <a href="#" class="logo">
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
              <a href="#home" class="navbar-link active" data-nav-link>Home</a>
            </li>

            <li>
              <a href="#about" class="navbar-link" data-nav-link>About Us</a>
            </li>

            <li>
              <a href="#class" class="navbar-link" data-nav-link>Classes</a>
            </li>

            <li>
              <a href="#blog" class="navbar-link" data-nav-link>Blog</a>
            </li>

            <li>
              <a href="#" class="navbar-link" data-nav-link>Contact Us</a>
            </li>
          </ul>
        </nav>

        <a href="#" class="btn btn-secondary">Join Now</a>

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
    <!-- Login Form - member (Initially Hidden) -->
    <div class="form-container" id="MemberForm">
      <form class="box" action="login.php" method="post">
        <div class="user-type-buttons" style="text-align: center;">
          <button type="button" onclick="showAdminForm()">Admin</button>
          <button type="button" onclick="showMemberForm()">Member</button>
        </div>
        <?php if (isset($_GET['error'])) { ?>
          <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <!-- Username and Password Fields -->
        <h2>MEMBER</h2>
        <label for="uname">User Name</label>
        <input type="text" id="uname" name="uname" placeholder="Enter username">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password">

        <!-- Login Button -->
        <button type="submit">Login</button>

        <!-- Registration Link -->
        <p>Not yet registered? <a href="ManualSignUp2.php">Register</a></p>
      </form>
    </div>

    <!-- Login Form - admin (Initially Hidden) -->
    <div class="form-container" id="AdminForm" style="display: none;">
      <form class="box" action="admin-login.php" method="post">
        <div class="user-type-buttons" style="text-align: center" display="inline-block">
          <button type="button" id="userTypeAdmin" onclick="showAdminForm()">Admin</button>
          <button type="button" id="userTypeMember" onclick="showMemberForm()">Member</button>
        </div>
        <?php if (isset($_GET['error'])) { ?>
          <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>

        <!-- Username and Password Fields -->
        <h2>ADMIN</h2>
        <label for="Username">User Name</label>
        <input type="text" id="Username" name="Username" placeholder="Enter username">

        <label for="Name">Name</label>
        <input type="text" id="Name" name="Name" placeholder="Enter Name">

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password">

        <!-- Login Button -->
        <button type="submit">Login as Admin</button>
      </form>
    </div>

    <!-- JavaScript to Toggle Visibility -->
    <script>
      function showMemberForm(userType) {
        // Set the user type in the hidden input
        document.getElementById('userTypeMember').value = userType;

        // Show the login form
        document.getElementById('AdminForm').style.display = 'none';
        document.getElementById('MemberForm').style.display = 'block';
      }
      function showAdminForm(userType) {
        // Set the user type in the hidden input
        document.getElementById('userTypeAdmin').value = userType;

        // Show the login form
        document.getElementById('AdminForm').style.display = 'block';
        document.getElementById('MemberForm').style.display = 'none';
      }
    </script>
    
    <!-- For Footer Part -->
    <footer class="footer">
      <div
        class="section footer-top bg-dark has-bg-image"
        style="background-image: url('images/footer-bg.png')"
      >
        <div class="container">
          <div class="footer-brand">
          <a href="#" class="logo">
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

                  <p>7:00AM - 10:00PM</p>
                </li>

                <li>
                  <p class="footer-brand-title">Saturday - Sunday</p>

                  <p>9:00AM - 5:00PM</p>
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
              <a href="#" class="footer-link">Contact Us</a>
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
                <a href="tel:09357394500" class="footer-link">0935-739-4500</a>

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
                  <a href="#" class="social-link">
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
            &copy; 2023 FitnessZone. All Rights Reserved By
            <a href="#" class="copyright-link">JacksGentlemen.</a>
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
