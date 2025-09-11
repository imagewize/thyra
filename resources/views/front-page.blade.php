@extends('layouts.app')

@section('content')
  {{-- Block-Based Content --}}
  @if (have_posts())
    @while (have_posts()) @php(the_post())
      {{-- WordPress Block Content --}}
      <div class="block-editor-content">
        @php(the_content())
      </div>
    @endwhile
  @endif
@endsection