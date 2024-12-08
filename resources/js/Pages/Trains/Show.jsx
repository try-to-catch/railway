import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({train}) {
    return (
        <AuthenticatedLayout>
            <Head title="Train"/>
            <div style={{display: 'flex', justifyContent: 'space-evenly'}}>
                <ul>
                    <li>id: {train.id}</li>
                    <li>name: {train.name}</li>
                    <li>from: {train.from}</li>
                    <li>to: {train.to}</li>
                    <li>carriage count: {train.carriages.length}</li>
                </ul>
            </div>
        </AuthenticatedLayout>
    );
}
