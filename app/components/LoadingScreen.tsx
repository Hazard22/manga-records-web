import { Mosaic } from "react-loading-indicators";

export default function LoadingScreen() {
    return (
        <div className='fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50'>
            <Mosaic color='#ffffff'/>
        </div>
    )
}
