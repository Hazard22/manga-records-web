import { Manga } from '@/app/types/manga'
import { Grid2 } from '@mui/material'
import React from 'react'
import MangaCard from './MangaCard'

interface MangaGalleryProps {
    mangas: Manga[]
}

export default function MangaGallery( {mangas} : MangaGalleryProps ) {
  return (
    <div className='flex h-full'>
        <div className='m-auto'>
        <Grid2 container spacing={{ xs: 2, md: 3 }} columns={{ xs: 4, sm: 8, md: 12 }}>
            {mangas.map((manga) => (
                <MangaCard key={manga.id} manga={manga}/>
            ))}
        </Grid2>
        </div>
    </div>
    
  )
}
