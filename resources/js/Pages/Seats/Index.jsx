import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ seats }) {
    console.log(seats.data); 

    return (
        <AuthenticatedLayout>
            <Head title="Seats" />

            <div style={{ padding: '20px', display: 'flex', flexWrap: 'wrap', gap: '20px' }}>
                {seats.data.map((seat, index) => (
                    <div key={index} style={{ border: '1px solid #ccc', padding: '10px', borderRadius: '8px', width: '200px', backgroundColor: '#f8f9fa' }}>
                        <h3 style={{ textAlign: 'center' }}>Seat {seat.number}</h3>
                        <ul>
                            <li><strong>ID:</strong> {seat.id}</li>
                            <li><strong>Reserved:</strong> {seat.is_reserved ? 'Yes' : 'No'}</li>
                            <li><strong>Number:</strong> {seat.number}</li>
                        </ul>
                    </div>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
