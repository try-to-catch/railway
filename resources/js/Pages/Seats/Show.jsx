import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head, Link } from '@inertiajs/react'

export default function Show ({ seat }) {
    return (
        <AuthenticatedLayout>
            <Head title='Seat' />
            <div
                style={{
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    padding: '20px'
                }}
            >
                <div
                    style={{
                        display: 'block',
                        border: '1px solid #ccc',
                        borderRadius: '8px',
                        padding: '20px',
                        boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                        textAlign: 'center',
                        backgroundColor: seat.is_reserved
                            ? '#f8d7da'
                            : '#d4edda',
                        width: '100%',
                        maxWidth: '400px'
                    }}
                >
                    <h3 style={{ marginBottom: '15px' }}>Seat {seat.number}</h3>
                    <ul style={{ listStyle: 'none', padding: 0 }}>
                        <li style={{ marginBottom: '10px' }}>
                            <strong>ID:</strong> {seat.id}
                        </li>
                        <li style={{ marginBottom: '10px' }}>
                            <strong>Number:</strong> {seat.number}
                        </li>
                        <li style={{ marginBottom: '10px' }}>
                            <strong>Reserved:</strong>{' '}
                            {seat.is_reserved ? 'Yes' : 'No'}
                        </li>
                    </ul>
                </div>
                <Link
                    href={`/carriages/${seat.carriage_id}/seats`}
                    style={{
                        marginTop: '20px',
                        padding: '10px 20px',
                        backgroundColor: '#007bff',
                        color: 'white',
                        textDecoration: 'none',
                        borderRadius: '5px',
                        fontSize: '16px'
                    }}
                >
                    Back to Seats
                </Link>
            </div>
        </AuthenticatedLayout>
    )
}
