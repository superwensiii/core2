<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
    }

    .profile-section {
      max-width: 600px;
      width: 100%;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-image {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .profile-image img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .form-label {
      font-weight: bold;
    }

    button[type="submit"] {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="profile-section">
    <h4 class="text-center">My Profile</h4>
    <p class="text-center text-muted">Manage and protect your account</p>
    <form>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Enter Username">
        <small class="text-muted">Username can only be changed once.</small>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" placeholder="Enter your email">
        <a href="#" class="d-block mt-1">Change</a>
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phone" placeholder="Enter your phone number">
        <a href="#" class="d-block mt-1">Change</a>
      </div>
      <div class="mb-3">
        <label class="form-label">Gender</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="male" value="Male" checked>
          <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
          <label class="form-check-label" for="female">Female</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
          <label class="form-check-label" for="other">Other</label>
        </div>
      </div>
      <div class="mb-3">
        <label for="dob" class="form-label">Date of Birth</label>
        <div class="d-flex">
          <select class="form-select me-2" style="max-width: 100px;">
            <option>Date</option>
            <!-- Add options for dates -->
          </select>
          <select class="form-select me-2" style="max-width: 120px;">
            <option>Month</option>
            <!-- Add options for months -->
          </select>
          <select class="form-select" style="max-width: 140px;">
            <option>Year</option>
            <!-- Add options for years -->
          </select>
        </div>
      </div>
      <div class="mb-3 profile-image">
        <img src="https://via.placeholder.com/100" alt="Profile Image">
        <button type="button" class="btn btn-outline-secondary btn-sm mt-2">Select Image</button>
        <small class="text-muted">File size: maximum 1 MB<br>File extension: .JPEG, .PNG</small>
      </div>
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
</body>
</html>
