<div class="profile-sidebar border">
    <div class="widget">
      <h5 class="mb-2 border-bottom pb-3">
        <i class="fa fa-user default-user"></i>
      </h5>

      <div class="list-group mt-3">
        <a href="{{ route('users.profile', Auth::user()->username ) }}" class="list-group-item list-group-item-action">
          Profile
        </a>
        <a href="{{ route('users.dashboard') }}" class="list-group-item list-group-item-action">
          Dashboard
        </a>
        <a href="{{ route('users.dashboard.books')}}" class="list-group-item list-group-item-action">
          My Uploaded Books
        </a>
        <a href="ordered-books.html" class="list-group-item list-group-item-action">
          My Orderd Books
        </a>
        <a href="#" class="list-group-item list-group-item-action">
          My Requests
        </a>
      </div>

    </div> <!-- Single Widget -->
  </div>
