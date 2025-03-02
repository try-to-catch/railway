import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link} from '@inertiajs/react';

export default function Index({ carriages, train, schedule_id }) {
    return (
        <AuthenticatedLayout>
            <Head title="Carriages" />
            <div style={{ padding: '20px' }}>
                <h2 style={{ textAlign: 'center', marginBottom: '30px' }}>
                    Carriages for Train {train.id}
                </h2>

                <div style={{ textAlign: 'center', marginBottom: '30px' }}>
                    <Link
                        href={route('trains.edit', {train: train.id})}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#007bff',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px',
                        }}
                    >
                        Edit Train
                    </Link>

                    <Link
                        href={route('trains.trips.create', {train: train.id})}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#007bff',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px',
                            marginRight: '10px',
                            marginLeft: '10px',
                        }}
                    >
                        Create trip
                    </Link>

                    <Link
                        href={`/trains/${train.id}/carriages/create`}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#28a745',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px',
                        }}
                    >
                        Create Carriage
                    </Link>
                </div>

                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center' }}>
                    {carriages.data.map((carriage, index) => (
                        <Link
                            key={index}
                            href={route('carriages.seats.index', {
                                carriage: carriage.id,
                                schedule_id: schedule_id
                            })}
                            style={{
                                textDecoration: 'none',
                                backgroundColor: '#f8f9fa',
                                border: '1px solid #ddd',
                                borderRadius: '8px',
                                padding: '20px',
                                boxShadow: '0 4px 6px rgba(0, 0, 0, 0.1)',
                                textAlign: 'center',
                                display: 'block',
                            }}
                        >
                            <h3 style={{ marginBottom: '15px' }}>Carriage {carriage.number}</h3>
                            <ul style={{ listStyle: 'none', padding: 0 }}>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>ID:</strong> {carriage.id}
                                </li>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>Class:</strong> {carriage.class}
                                </li>
                                <li style={{ marginBottom: '10px' }}>
                                    <strong>Number:</strong> {carriage.number}
                                </li>
                            </ul>
                        </Link>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
