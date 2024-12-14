import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ trains }) {
    return (
        <AuthenticatedLayout>
            <Head title="Trains" />
            <div style={{ textAlign: 'center', marginBottom: '20px' }}>
                <h2>Trains</h2>
            </div>
            <div
                style={{
                    display: 'flex',
                    flexWrap: 'wrap',
                    justifyContent: 'center',
                    gap: '20px',
                    padding: '20px',
                }}
            >
                {trains.data.map((train, index) => (
                    <Link
                        key={index}
                        href={route('trains.edit', { train: train.id })}
                        style={{
                            textDecoration: 'none',
                            border: '1px solid #ccc',
                            borderRadius: '8px',
                            padding: '15px',
                            minWidth: '200px',
                            textAlign: 'center',
                            backgroundColor: '#f8f9fa',
                        }}
                    >
                        <h3 style={{ marginBottom: '10px' }}>Train {train.name}</h3>
                        <ul style={{ listStyle: 'none', padding: 0, lineHeight: '1.6' }}>
                            <li>
                                <strong>ID:</strong> {train.id}
                            </li>
                            <li>
                                <strong>From:</strong> {train.from}
                            </li>
                            <li>
                                <strong>To:</strong> {train.to}
                            </li>
                        </ul>
                    </Link>
                ))}
            </div>
            <Link
                href={route('trains.create')}
                style={{
                    padding: '10px 15px',
                    backgroundColor: '#28a745',
                    color: '#fff',
                    borderRadius: '4px',
                    textDecoration: 'none',
                    fontSize: '20px',
                    alignItems: 'start',
                }}
            >
                <span style={{ marginRight: '5px' }}>+</span> Create Train
            </Link>
        </AuthenticatedLayout>
    );
}
