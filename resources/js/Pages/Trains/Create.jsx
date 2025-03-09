import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function CreateTrain() {
    const { data, setData, post, processing, reset, errors } = useForm({
        name: '',
        from: '',
        to: '',
        departure: '',
        arrival: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('trains.store'), {
            onSuccess: () => {
                alert('Train created successfully!');
                reset();
            },
            onError: () => {
                alert('Failed to create train. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Create Train" />

            <div
                style={{
                    maxWidth: '600px',
                    margin: '20px auto',
                    padding: '20px',
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    backgroundColor: '#f8f9fa',
                }}
            >
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>
                    Create Train
                </h2>
                <form onSubmit={handleSubmit}>
                    {/* Train Name */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="trainName"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Train Name:
                        </label>
                        <input
                            type="text"
                            id="trainName"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.name && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.name}
                            </div>
                        )}
                    </div>

                    {/* From Station */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="fromStation"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            From:
                        </label>
                        <input
                            type="text"
                            id="fromStation"
                            value={data.from}
                            onChange={(e) => setData('from', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.from && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.from}
                            </div>
                        )}
                    </div>

                    {/* To Station */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="toStation"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            To:
                        </label>
                        <input
                            type="text"
                            id="toStation"
                            value={data.to}
                            onChange={(e) => setData('to', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.to && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.to}
                            </div>
                        )}
                    </div>

                    {/* Departure Time */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="departure"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Departure Time:
                        </label>
                        <input
                            type="datetime-local"
                            id="departure"
                            value={data.departure}
                            onChange={(e) => setData('departure', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.departure && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.departure}
                            </div>
                        )}
                    </div>

                    {/* Arrival Time */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="arrival"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Arrival Time:
                        </label>
                        <input
                            type="datetime-local"
                            id="arrival"
                            value={data.arrival}
                            onChange={(e) => setData('arrival', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.arrival && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.arrival}
                            </div>
                        )}
                    </div>

                    {/* Submit Button */}
                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            display: 'block',
                            width: '100%',
                            padding: '10px',
                            backgroundColor: '#007bff',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: processing ? 'not-allowed' : 'pointer',
                        }}
                    >
                        {processing ? 'Creating...' : 'Create Train'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
