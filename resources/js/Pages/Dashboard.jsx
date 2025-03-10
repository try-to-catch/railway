import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Dashboard({ reservations, isAdmin }) {
    const [processingId, setProcessingId] = useState(null);

    const handleCancel = (id) => {
        if (confirm('Do you really want to cancel this reservation?')) {
            setProcessingId(id);
            router.delete(route('reservations.cancel', id), {
                onSuccess: () => setProcessingId(null),
                onError: () => setProcessingId(null),
            });
        }
    };

    const isDateInFuture = (dateString) => {
        const date = new Date(dateString);
        return date > new Date();
    };

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {isAdmin && (
                        <div className="mb-4 p-4 bg-blue-100 rounded-lg">
                            <p className="text-blue-700 font-semibold">
                                You are logged in as an administrator and see all reservations in the system
                            </p>
                        </div>
                    )}

                    {!reservations?.length ? (
                        <p style={{textAlign: 'center', fontSize: '24px'}}>
                            {isAdmin ? 'There are no reservations in the system' : 'You haven\'t made any reservations'}
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
                            {reservations.map((reservation, index) => (
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
                                    <h3 style={{ marginBottom: '15px' }}>Место {reservation.seat.number}</h3>
                                    <ul style={{ listStyle: 'none', padding: 0 }}>
                                        {isAdmin && (
                                            <li style={{marginBottom: '10px', fontWeight: 'bold', color: '#3b82f6'}}>
                                                <strong>User:</strong> {reservation.user.name}
                                            </li>
                                        )}
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Train:</strong> {reservation.seat.carriage.train.name}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>From:</strong> {reservation.seat.carriage.train.from}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>To:</strong> {reservation.seat.carriage.train.to}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Departure:</strong> {reservation.train_schedule.departure}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Arrival:</strong> {reservation.train_schedule.arrival}
                                        </li>
                                        <li style={{marginBottom: '10px'}}>
                                            <strong>Price:</strong> {reservation.price}$
                                        </li>
                                    </ul>

                                    {isDateInFuture(reservation.train_schedule.departure) && (
                                        <button
                                            onClick={() => handleCancel(reservation.id)}
                                            disabled={processingId === reservation.id}
                                            className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        >
                                            {processingId === reservation.id ? 'Cancellation...' : 'Cancel reservation'}
                                        </button>
                                    )}
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
