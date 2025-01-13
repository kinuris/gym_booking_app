<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #333;
            border-radius: 10px;
            background-color: #1e1e1e;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            color: #00bcd4;
        }
        .form-group input, .form-group textarea {
            width: 90%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #333;
            color: #e0e0e0;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #00bcd4;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register as Gym Instructor</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/register" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" required>{{ old('bio') }}</textarea>
            </div>
            <div class="form-group">
                <label for="rate_hourly">Hourly Rate (PHP)</label>
                <input type="number" id="rate_hourly" name="hourly_rate" value="{{ old('rate_hourly') }}" required>
            </div>
            <div class="form-group">
                <label for="rate_monthly">Monthly Rate (PHP)</label>
                <input type="number" id="rate_monthly" name="monthly_rate" value="{{ old('rate_monthly') }}" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required style="width: 90%; padding: 10px; margin-top: 5px; border: 1px solid #333; border-radius: 5px; background-color: #333; color: #e0e0e0;">
                    <option value="" disabled selected>Select your gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
