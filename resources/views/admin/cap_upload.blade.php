@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0;">CAP File Management</h1>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background-color: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">Upload CAP Document</h3>
        <form action="{{ route('admin.cap.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="cap_file" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">
                    Select PDF File <span style="color: #dc3545;">*</span>
                </label>
                <input type="file" id="cap_file" name="cap_file" accept="application/pdf" 
                       style="display: block; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; width: 100%; box-sizing: border-box;" required>
                <small style="color: #6c757d; display: block; margin-top: 5px;">Maximum file size: 10MB. Only PDF files allowed.</small>
            </div>
            <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">
                Upload File
            </button>
        </form>
    </div>

    <div>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">Uploaded Files ({{ $caps->total() }})</h3>
        @forelse($caps as $cap)
            <div style="background-color: white; padding: 15px; border: 1px solid #dee2e6; border-radius: 4px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1;">
                    <p style="margin: 0 0 8px 0; font-weight: 500; color: #333;">{{ $cap->original_name }}</p>
                    <p style="margin: 0; font-size: 13px; color: #6c757d;">
                        Uploaded by <strong>{{ $cap->user->name }}</strong> on {{ $cap->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.cap.download', $cap->id) }}" 
                       style="background-color: #28a745; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 13px; display: inline-block;">
                        Download
                    </a>
                    <form action="{{ route('admin.cap.destroy', $cap->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background-color: #dc3545; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div style="background-color: #f8f9fa; padding: 40px; border-radius: 4px; text-align: center; color: #6c757d;">
                <p style="margin: 0;">No files uploaded yet. Start by uploading a CAP document above.</p>
            </div>
        @endforelse

        @if($caps->hasPages())
            <div style="margin-top: 20px; display: flex; justify-content: center;">
                {{ $caps->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
