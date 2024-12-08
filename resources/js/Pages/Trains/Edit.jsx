import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';

export default function Show({train}) {
    return (
        <AuthenticatedLayout>
            <Head title="Edit train"/>
            Edit Train
        </AuthenticatedLayout>
    );
}
