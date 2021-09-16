{{-- :posts="$post" View/Component로 가서 생성자가 받음 --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Post') }}
            </h2>
            <button onclick=location.href="{{ route('posts.index') }}" 
                    type="button" 
                    class="btn btn-info hover:bg-blue-700 font-bold text-white"
                    >
                    목록보기
            </button>
        </div>
    </x-slot>
    <div class="m-6 p-6">
        {{-- file보내는 form에서 method="post enctype="multipart" --}}
        <form class="row g-3" 
              action="{{ route('posts.store') }}"
              method="post" 
              enctype="multipart/form-data">    
            @csrf
            <div class="col-12 m-2">
                <label for="title" class="form-label">제목</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="제목 입력" value="{{ old('title') }}"/>
                @error('title')
                    <div class="text-red-800">
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="col-12 m-2">
                <label for="content" class="form-label">글 내용</label>
                <textarea 
                    class="form-control" 
                    name="content" 
                    id="content" 
                    cols="30" rows="10" 
                    >{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-red-800">
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="col-12 m-2">
                <label for="image" class="form-label">첨부 이미지</label>
                <input type="file" name="image" class="form-control" id="image" value="{{ old('title') }}">
            </div>
            <div class="col-12 m-2">
              <button type="submit" class="btn btn-primary">글저장</button>
            </div>
        </form>
    </div>
</x-app-layout>
