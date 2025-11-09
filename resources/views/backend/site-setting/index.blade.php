@extends('backend.layout.app')
@section('title', 'Register Users')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Site Setting</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Site Setting</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Page title</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr No</th>
                                <th>Page title</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($site_settings as $site_setting)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $site_setting->page_title }}</td>
                                <td>
                                    <a href="{{ $site_setting->getFirstMediaUrl('images') }}" target="_blank">
                                        <img src="{{ $site_setting->getFirstMediaUrl('images') }}" height="60px" width="60px">
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="text-primary" data-toggle="modal" data-target="#editModal{{ $site_setting->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $site_setting->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $site_setting->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $site_setting->id }}">Edit Image</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Your image editing form goes here -->
                                                <form action="{{ route('site-setting.update', $site_setting->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="image">Choose Image:</label>
                                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Image</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

   <!-- Additional Section for CSS -->
   <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">CSS Section</h1>
    <div>
        <form action="{{ route('update.css') }}" method="POST">
            @csrf
            <textarea id="css-editor" name="site_css" rows="10" style="width: 100%"> {!! $site_css->site_css ?? '' !!}</textarea>
            <button type="submit" class="btn btn-primary mt-2">Update CSS</button>
        </form>
    </div>
</div>

<!-- Include CodeMirror Initialization Script -->
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("css-editor"), {
        lineNumbers: true,
        theme: "monokai", // Optional: Change theme as needed
        mode: "css"
    });
</script>
@endsection
