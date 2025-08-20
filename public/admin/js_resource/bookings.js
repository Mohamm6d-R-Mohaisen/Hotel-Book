

// Column definitions for admins table
window.columns = [
    {data: 'id'},
    {data: 'user_name'},
    {data: 'room_number'},
    {data: 'check_in'},
    {data: 'check_out'},
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
        orderable: false
    }
];


