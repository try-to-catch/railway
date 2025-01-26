import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({seats}) {
    console.log(seats);

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {seats.length === 0 ? (
                        <p style={{textAlign: 'center', fontSize: '24px'}}>
                            You didn't make reservations
                        </p>
                    ) : (
                        <div
                            style={{
                                display: 'flex',
                                flexWrap: 'wrap',
                                gap: '20px',
                                justifyContent: 'center'
                            }}
                        >
                            {seats.map((seat, index) => (
                                <div
                                    key={index}
                                    style={{
                                        textDecoration: 'none',
                                        display: 'block',
                                        border: '1px solid #ccc',
                                        borderRadius: '8px',
                                        padding: '20px',
                                        minWidth: '200px',
                                        textAlign: 'center',

                                        boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                                    }}
                                >
                                    <h3 style={{marginBottom: '15px'}}>
                                        Seat {seat.number}
                                    </h3>
                                    <ul style={{listStyle: 'none', padding: 0}}>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>ID:</strong> {seat.id}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>From:</strong> {seat.carriage.train.from}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>To:</strong> {seat.carriage.train.to}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Departure:</strong> {seat.carriage.train.departure}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Arrival:</strong> {seat.carriage.train.arrival}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Price:</strong> {seat.price}$
                                        </li>
                                    </ul>
                                </div>
                            ))}
                        </div>
                    )}
                </div>

            </div>
        </AuthenticatedLayout>
    );
}
