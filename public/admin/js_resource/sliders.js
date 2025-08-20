
// Column definitions for users table
window.columns = [
    {data: 'id'},
    {data: 'title'},
    {data: 'sub_title'},
    {data: 'description'},
    {data: 'operations'}
];

// Column definitions for special handling
window.columnDefs = [
    {
        targets: 0,
        orderable: false,
        sorting: false
    },
    {
        targets: -1,
        orderable: false,
    },
];