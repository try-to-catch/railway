import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ carriages, train }) {
    return (
        <AuthenticatedLayout>
            <Head title="Carriages" />
            <div style={{ padding: '20px' }}>
                <h2 style={{ textAlign: 'center', marginBottom: '30px' }}>
                    Carriages for Train {train.id}
                </h2>

                <div style={{ textAlign: 'center', marginBottom: '30px' }}>
                    <Link
                        href={`/trains/${train.id}/carriages/create`}
                        style={{
                            padding: '10px 20px',
                            backgroundColor: '#007bff',
                            color: 'white',
                            textDecoration: 'none',
                            borderRadius: '5px',
                            fontSize: '16px',
                        }}
                    >
                        Create Carriage
                    </Link>
                </div>

                <div
                    style={{
                        display: 'grid',
                        gridTemplateColumns: 'repeat(auto-fill, minmax(250px, 1fr))',
                        gap: '20px',
                        justifyContent: 'center',
                    }}
                >
                    {carriages.data.map((carriage, index) => (
                        <Link
                            key={index}
                            href={`/carriages/${carriage.id}/edit`}  // Переход на страницу редактирования
                            style={{
                                textDecoration: 'none',  // Убираем подчеркивание
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
