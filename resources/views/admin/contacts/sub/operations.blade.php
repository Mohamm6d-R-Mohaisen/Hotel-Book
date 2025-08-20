<div class="tableActions">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal-{{ $instance->id }}">
    Reply
</button>
    
    <a class="svg-icon" data-kt-docs-table-filter="delete_row" data-action="{{route('admin.contacts.destroy', ['contact'=> $instance->id])}}">
        <svg data-kt-docs-table-filter="delete_row" data-action="{{route('admin.contacts.destroy', ['contact'=> $instance->id])}}" xmlns="http://www.w3.org/2000/svg"
                width="19.28" height="19.28"
                viewBox="0 0 19.28 19.28">
            <path id="trash-Bold_1_" d="M655.316,1822.892h-3.431a.964.964,0,0,1-.915-.658l-.3-.916a1.927,1.927,0,0,0-1.829-1.318h-4.395a1.925,1.925,0,0,0-1.829,1.319l-.3.914a.963.963,0,0,1-.915.659h-3.43a.964.964,0,0,0,0,1.928h1.027l.724,10.86a3.865,3.865,0,0,0,3.847,3.6h6.157a3.866,3.866,0,0,0,3.847-3.6l.724-10.86h1.026a.964.964,0,0,0,0-1.928Zm-10.873-.964h4.395l.3.916c.006.017.014.032.021.049h-5.046c.006-.017.015-.033.021-.05Zm7.2,13.624a1.933,1.933,0,0,1-1.924,1.8h-6.157a1.933,1.933,0,0,1-1.924-1.8l-.714-10.732h.472a2.917,2.917,0,0,0,.306-.024.842.842,0,0,0,.121.024h9.64a1.01,1.01,0,0,0,.121-.024,2.9,2.9,0,0,0,.306.024h.472Zm-2.11-6.876v4.82a.964.964,0,1,1-1.928,0v-4.82a.964.964,0,0,1,1.928,0Zm-3.856,0v4.82a.964.964,0,1,1-1.928,0v-4.82a.964.964,0,0,1,1.928,0Z" transform="translate(-637 -1820)" fill="#103349" />
        </svg>
    </a>
</div>


<div class="modal fade" id="replyModal-{{ $instance->id }}" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.contacts.reply', $instance->id) }}" class="modal-content reply-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="reply" class="form-label">Reply content</label>
                    <textarea name="reply" id="reply" class="form-control" rows="5" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="padding: 10px !important">Send</button>
            </div>
        </form>
    </div>
</div>