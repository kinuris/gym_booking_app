<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Profile</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            background-color: #333333;
            color: #f4f4f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #444444;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-picture img {
            border-radius: 50%;
            border: 3px solid #1e90ff;
            object-fit: cover;
            width: 150px;
            height: 150px;
        }

        .profile-details {
            margin-left: 30px;
        }

        .profile-details h1 {
            margin: 0;
            font-size: 24px;
            color: #1e90ff;
        }

        .profile-details p {
            margin: 5px 0 0;
            font-size: 16px;
            color: #cccccc;
        }
    </style>
</head>

<body>
    @if($notifications->isNotEmpty())
        <div class="notifications-panel max-w-[270px] max-h-96" style="position: fixed; top: 64px; right: 20px; background-color: #444444; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <button onclick="this.parentElement.style.display='none';" style="background: none; border: none; color: #f4f4f9; font-size: 16px; position: absolute; top: 10px; right: 10px; cursor: pointer;">&times;</button>
            <h2 style="color: #1e90ff; margin: 0 0 10px;">Notifications</h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach($notifications as $notification)
                <li style="margin-bottom: 10px; color: #cccccc;">
                <strong style="color: #1e90ff;">{{ $notification->title }}</strong>
                <p style="margin: 5px 0 0; color: #f4f4f9;">{{ $notification->body }}</p>
                <p class="text-[10px] text-right">{{ $notification->created_at }}</p>
                </li>
            @endforeach
            </ul>
        </div>
    @endif

    @include('instructor.nav')
    <div class="container mt-24">
        <div class="profile-rates">
            <form action="/instructor/updateprice/{{ $instructor->id }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="hourly_rate">Hourly Rate:</label>
                    <input type="text" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $instructor->hourly_rate) }}" required>
                    @error('hourly_rate')
                        <span class="error" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="monthly_rate">Monthly Rate:</label>
                    <input type="text" id="monthly_rate" name="monthly_rate" value="{{ old('monthly_rate', $instructor->monthly_rate) }}" required>
                    @error('monthly_rate')
                        <span class="error" style="color: red;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit">update rates</button>
            </form>
        </div>

        <div class="profile" style="flex-direction: row; width: 100%;">
            <div class="profile-picture">
                <img src="{{ asset('storage/' . $instructor->profile_image) }}" alt="Profile Picture">
            </div>
            <div class="profile-details" style="flex-grow: 1;">
                <form action="/instructor/updateprofile/{{ $instructor->id }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group" style="display: flex; gap: 30px;">
                        <div class="flex-1">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="{{ $instructor->first_name }}" required>
                        </div>
                        <div class="flex-1">
                            <label for="middle_name">Middle Name:</label>
                            <input type="text" id="middle_name" name="middle_name" value="{{ $instructor->middle_name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $instructor->last_name }}" required>
                    </div>
                    <div class="form-group" style="display: flex; gap: 30px;">
                        <div class="flex-1">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="{{ $instructor->email }}" required>
                        </div>
                        <div>
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ $instructor->phone_number }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bio">Bio:</label>
                        <textarea id="bio" name="bio" rows="4" required>{{ $instructor->bio }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profile Image:</label>
                        <input type="file" id="profile_image" name="profile_image">
                    </div>

                    <button type="submit">Update Profile</button>
                </form>
            </div>
        </div>
        <style>
            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
                color: #f4f4f9;
            }

            .form-group input,
            .form-group textarea {
                width: 100%;
                padding: 10px;
                border: 1px solid #555555;
                border-radius: 5px;
                background-color: #333333;
                color: #f4f4f9;
            }

            .form-group input[type="file"] {
                padding: 3px;
            }

            button[type="submit"] {
                background-color: #1e90ff;
                color: #f4f4f9;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button[type="submit"]:hover {
                background-color: #1c86ee;
            }
        </style>
</body>

</html>