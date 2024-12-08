import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ carriages }) {
    console.log(carriages.data)
    return (
        <AuthenticatedLayout>
            <Head title="Carriages"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                {carriages.data.map((carriage, index) => (
                    <ul key={index}>
                        <li>ID: {carriage.id}</li>
                        <li>class: {carriage.class}</li>
                        <li>number: {carriage.number}</li>
                    </ul>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
