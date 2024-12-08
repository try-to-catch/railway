import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({ trains }) {
    console.log(trains.data)
    return (
        <AuthenticatedLayout>
            <Head title="Trains"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                {trains.data.map((train, index) => (
                    <ul key={index}>
                        <li>id: {train.id}</li>
                        <li>name: {train.name}</li>
                        <li>from: {train.from}</li>
                        <li>to: {train.to}</li>
                    </ul>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
