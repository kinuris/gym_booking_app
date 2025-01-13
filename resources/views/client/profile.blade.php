<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 10px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #ffffff;
            border: none;
        }

        .form-control:focus {
            background-color: #2c2c2c;
            color: #ffffff;
            border-color: #4a90e2;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #357ab8;
        }
    </style>
</head>

<body>
    @if($notifications->isNotEmpty())
        <div class="notifications-panel max-w-[270px] max-h-96" style="position: fixed; top: 64px; right: 20px; background-color: #444444; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <button onclick="this.parentElement.style.display='none';" style="background: none; border: none; color: #f4f4f9; font-size: 16px; position: absolute; top: 10px; right: 10px; cursor: pointer;">&times;</button>
            <h2 class="text-base" style="color: #1e90ff; margin: 0 0 10px;">Notifications</h2>
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

    @include('client.nav')
    <div class="profile-container">
        <h2 class="text-center">Client Profile</h2>
        <form action="/client/updateprofile/{{ $client->id }}" method="POST">
            @csrf
            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $client->profile_image) }}" alt="Profile Image" class="profile-image" id="profileImage">
                <input type="file" class="form-control mt-4 @error('profile_image') is-invalid @enderror" id="profileImageInput" accept="image/*" onchange="loadFile(event)">
                @error('profile_image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" value="{{ $client->first_name }}" class="form-control @error('first_name') is-invalid @enderror" id="firstName" name="first_name" placeholder="First Name">
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="middleName" class="form-label">Middle Name</label>
                <input type="text" value="{{ $client->middle_name }}" class="form-control @error('middle_name') is-invalid @enderror" id="middleName" name="middle_name" placeholder="Middle Name">
                @error('middle_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" value="{{ $client->last_name }}" class="form-control @error('last_name') is-invalid @enderror" id="lastName" name="last_name" placeholder="Last Name">
                @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" value="{{ $client->phone_number }}" class="form-control @error('phone_number') is-invalid @enderror" id="phoneNumber" name="phone_number" placeholder="Phone Number">
                @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" value="{{ $client->email }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                    <option value="male" {{ $client->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $client->gender == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ $client->gender == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" value="{{ $client->birthdate }}" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate">
                @error('birthdate')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>

    <script>
        function loadFile(event) {
            var image = document.getElementById('profileImage');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</body>

</html>