import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ seats }) {
    console.log(seats.data)
    return (
        <AuthenticatedLayout>
            <Head title="Seats"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                {seats.data.map((seat, index) => (
                    <ul key={index}>
                        <li>id: {seat.id}</li>
                        <li>is_reserved: {seat.is_reserved}</li>
                        <li>number: {seat.number}</li>
                    </ul>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
