

// Column definitions for users table
window.columns = [
    {data: 'id'},
    {data: 'name'},
    {data: 'email'},
    {data: 'status'},
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


