'use client'

import useMangaStore from "@/app/store/mangaStore";
import { Typography } from "@mui/material";
import { Slide } from "react-awesome-reveal";

export default function Manga({ params } : { params: Promise<{ id: string }>}) {

    const { manga } = useMangaStore()

    return (
        <>
        <div className="w-full max-h-72 relative overflow-hidden">
        <Slide direction="right">
            <img 
            src={`${manga?.bannerImgUrl}`} 
            alt="Banner" 
            className="w-full opacity-70 hover:opacity-100 transition-opacity"
            />
        </Slide>
        <div className="absolute top-4 left-6">
                <Typography variant="h3">{manga?.title}</Typography>
                <Typography variant="h5">Tomos adquiridos: {manga?.purchasedVolumes}</Typography>
                <Typography variant="h5">Tomos totales: {manga?.totalVolumes}</Typography>
        </div>
        </div>
        </>
    )
}
