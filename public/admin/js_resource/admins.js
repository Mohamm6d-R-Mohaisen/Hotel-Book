

// Column definitions for admins table
window.columns = [
    {data: 'id'},
    {data: 'name'},
    {data: 'email'},
    {data: 'created_at'},
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


