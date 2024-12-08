import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({seat}) {
    return (
        <AuthenticatedLayout>
            <Head title="Seat"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                <ul>
                    <li>id: {seat.id}</li>
                    <li>number: {seat.number}</li>
                    <li>is_reserved: {seat.is_reserved}</li>
                </ul>
            </div>
        </AuthenticatedLayout>
    );
}
