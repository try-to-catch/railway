import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({carriage}) {
    return (
        <AuthenticatedLayout>
            <Head title="Carriages"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                <ul>
                    <li>ID: {carriage.id}</li>
                    <li>class: {carriage.class}</li>
                    <li>number: {carriage.number}</li>
                    <li>seats count: {carriage.seats.length}</li>
                </ul>
            </div>
        </AuthenticatedLayout>
    );
}
