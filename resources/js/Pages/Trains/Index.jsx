import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';

export default function Index({ trains }) {
    const {data, setData, get} = useForm({
        min_price_b: '',
        max_price_b: '',
        min_price_binary: '',
        max_price_binary: '',
        from: '',
        to: '',
        date: '',
    });

    const handleFilter = (e) => {
        e.preventDefault();
        get(route('trains.index'), {preserveState: true});
    };

    return (
        <AuthenticatedLayout>
            <Head title="Trains" />
            <div style={{ textAlign: 'center', marginBottom: '20px' }}>
            </div>

            {/* Форма фильтров */}
            <form onSubmit={handleFilter} style={{textAlign: 'center', marginBottom: '20px'}}>
                <div style={{display: 'flex', justifyContent: 'center', flexWrap: 'wrap', gap: '10px'}}>

                    <div  style={{border: '2px dashed', padding: '5px'}}>
                        <div style={{paddingBottom: '5px'}}>
                            <label>Min Price (B):</label>
                            <input
                                type="number"
                                value={data.min_price_b}
                                onChange={(e) => setData('min_price_b', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                        <div>
                            <label>Max Price (B):</label>
                            <input
                                type="number"
                                value={data.max_price_b}
                                onChange={(e) => setData('max_price_b', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                    </div>

                    <div style={{border: '2px dashed', padding: '5px'}}>
                        <div style={{paddingBottom: '5px'}}>
                            <label>Min Price (Binary):</label>
                            <input
                                type="number"
                                value={data.min_price_binary}
                                onChange={(e) => setData('min_price_binary', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                        <div>
                            <label>Max Price (Binary):</label>
                            <input
                                type="number"
                                value={data.max_price_binary}
                                onChange={(e) => setData('max_price_binary', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                    </div>
                    <div style={{border: '2px dashed', padding: '5px'}}>
                        <div style={{paddingBottom: '5px'}}>
                            <label>From:</label>
                            <input
                                type="text"
                                value={data.from}
                                onChange={(e) => setData('from', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                        <div>
                            <label>To:</label>
                            <input
                                type="text"
                                value={data.to}
                                onChange={(e) => setData('to', e.target.value)}
                                style={{marginLeft: '10px', padding: '5px'}}
                            />
                        </div>
                    </div>
                    <div style={{border: '2px dashed', padding: '5px'}}>
                        <label>Departure:</label>
                        <input
                            type="date"
                            value={data.date}
                            onChange={(e) => setData('date', e.target.value)}
                            style={{marginLeft: '10px', padding: '5px'}}
                        />
                    </div>
                </div>
                <button
                    type="submit"
                    style={{
                        marginTop: '20px',
                        padding: '10px 20px',
                        backgroundColor: '#28a745',
                        color: 'white',
                        borderRadius: '5px',
                        fontSize: '16px',
                        border: 'none',
                        cursor: 'pointer',
                    }}
                >
                    Apply Filters
                </button>
            </form>

            {/* Отображение поездов */}
            <div style={{ textAlign: 'center', marginTop: '20px' }}>
                <Link
                    href={route('trains.create')}
                    style={{
                        padding: '10px 20px',
                        backgroundColor: '#007bff',
                        color: 'white',
                        textDecoration: 'none',
                        borderRadius: '5px',
                        fontSize: '16px',
                    }}
                >
                    Create Train
                </Link>
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
                        href={route('trains.carriages.index', { train: train.id })}
                        style={{
                            textDecoration: 'none',
                            border: '2px dashed #ccc',
                            borderRadius: '8px',
                            padding: '15px',
                            minWidth: '200px',
                            textAlign: 'center',
                            backgroundColor: '#f8f9fa',
                        }}
                    >
                        <h3 style={{ marginBottom: '10px' }}>Train {train.name}</h3>
                        <ul style={{ listStyle: 'none', padding: 0, lineHeight: '1.6' }}>
                            <li><strong>ID:</strong> {train.id}</li>
                            <li><strong>From:</strong> {train.from}</li>
                            <li><strong>To:</strong> {train.to}</li>
                            <li><strong>Departure:</strong> {train.departure}</li>
                            <li><strong>Arrival:</strong> {train.arrival}</li>
                        </ul>
                    </Link>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
