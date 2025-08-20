

// Column definitions for admins table
window.columns = [
    {data: 'id'},
    {data: 'name'},
    {data: 'price_per_night'},
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


