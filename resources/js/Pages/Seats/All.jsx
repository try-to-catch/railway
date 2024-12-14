import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ seats }) {
    return (
        <AuthenticatedLayout>
            <Head title="Seats" />
            <div style={{ padding: '20px' }}>
        
                <Link
                    href={route('carriages.seats.create', { carriage: seats.data[0].carriage_id })}
                    style={{
                        display: 'inline-block',
                        marginBottom: '20px',
                        padding: '10px 20px',
                        backgroundColor: '#28a745',
                        color: '#fff',
                        borderRadius: '50%',
                        fontSize: '20px',
                        textAlign: 'center',
                        textDecoration: 'none',
                        width: '40px',
                        height: '40px',
                        lineHeight: '20px',
                    }}
                >
                    +
                </Link>

                <div
                    style={{
                        display: 'flex',
                        flexWrap: 'wrap',
                        justifyContent: 'center',
                        gap: '20px',
                        padding: '20px'
                    }}
                >
                    {seats.data.map((seat, index) => (
                        <Link
                            key={index}
                            href={route('carriages.seats.edit', { seat: seat.id })}
                            style={{
                                textDecoration: 'none',
                                display: 'block',
                                border: '1px solid #ccc',
                                borderRadius: '8px',
                                padding: '15px',
                                minWidth: '150px',
                                textAlign: 'center',
                                backgroundColor: seat.is_reserved ? '#f8d7da' : '#d4edda',
                                color: seat.is_reserved ? '#721c24' : '#155724'
                            }}
                        >
                            <h3 style={{ margin: '0 0 10px' }}>Seat {seat.number}</h3>
                            <p>
                                <strong>ID:</strong> {seat.id}
                            </p>
                            <p>
                                <strong>Reserved:</strong> {seat.is_reserved ? 'Yes' : 'No'}
                            </p>
                        </Link>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
