@if (session('message'))
    <div style="position: fixed; bottom: 0; width: 100%; background-color: #333; color: #fff; text-align: center; padding: 10px;">
        {{ session('message') }}
    </div>
@endif

<div>
    <nav style="background-color: #444; padding: 10px;">
        <ul style="list-style-type: none; margin: 0; padding: 0; display: flex; justify-content: space-around;">
            <li><a href="/client" style="color: #fff; text-decoration: none; padding: 10px;">Profile</a></li>
            <li><a href="/my/sessions" style="color: #fff; text-decoration: none; padding: 10px;">My Sessions</a></li>
            <li><a href="/client/browse" style="color: #fff; text-decoration: none; padding: 10px;">Browse Instructors</a></li>
            <li><a href="/logout" style="color: #fff; text-decoration: none; padding: 10px;">Logout</a></li>
        </ul>
    </nav>
</div>