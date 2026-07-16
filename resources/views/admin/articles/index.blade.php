@extends('admin.layouts.app')

@section('content')

<div
class="
d-flex
justify-content-between
align-items-center
mb-4
"
>

    <div>

        <h2 class="mb-0">
            Analysis Articles
        </h2>

        <small class="text-muted">
            Total:
            {{ $articles->total() }}
            Articles
        </small>

    </div>

    <a
        href="/admin/articles/create"
        class="btn btn-danger"
    >Create Article</a>

</div>

<div class="card card-admin p-4">

<form
method="GET"
class="row g-3 mb-4"
>

    <div class="col-md-5">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search article..."
        >

    </div>

    <div class="col-md-3">

        <select
            name="status"
            class="form-control"
        >

            <option value="">
                All Status
            </option>

            <option
                value="published"
                {{ request('status') == 'published' ? 'selected' : '' }}
            >
                Published
            </option>

            <option
                value="draft"
                {{ request('status') == 'draft' ? 'selected' : '' }}
            >
                Draft
            </option>

        </select>

    </div>

    <div class="col-md-2">

        <button
            class="btn btn-dark w-100"
        >
            Filter
        </button>

    </div>

</form>

<div class="table-responsive">

<table
class="
table
table-hover
align-middle
"
>

<thead>

<tr>

    <th width="30%">Title</th>
    <th>Country</th>
    <th>Category</th>
    <th>Author</th>
    <th>Status</th>
    <th>Published</th>
    <th width="180">Action</th>

</tr>
</thead>
<tbody>
@forelse($articles as $article)
<tr>
    <td>
        <strong>
            {{ $article->title }}
        </strong>

    </td>
    <td>
        {{ $article->country->country_name ?? '-' }}
    </td>
    <td>
        {{ $article->category }}
    </td>
    <td>
        {{ $article->author }}
    </td>
    <td>
        @if(
            $article->status == 'published'
        )

            <span
                class="
                badge
                bg-success
                ">Published</span>

        @else
            <span
                class="
                badge
                bg-secondary
                "
            >
                Draft</span>

        @endif
    </td>
    <td>
        {{ optional($article->published_at)->format('d M Y') }}
    </td>
    <td>
        <a
            href="/admin/articles/{{ $article->id }}/edit"
            class="btn btn-sm btn-warning"
        >Edit</a>

        <form
            method="POST"
            action="/admin/articles/{{ $article->id }}"
            style="display:inline;"
        >

            @csrf
            @method('DELETE')

            <button
                onclick="
                return confirm(
                'Delete article?'
                )
                "
                class="btn btn-sm btn-danger"
            >Delete</button>

        </form>
    </td>
</tr>

@empty
<tr>
<td colspan="7">
<div
class="
alert
alert-info
mb-0
"
>No articles found</div>
</td>
</tr>

@endforelse
</tbody>
</table>
</div>
<div class="mt-4">

{{ $articles->links() }}
</div>
</div>
@endsection