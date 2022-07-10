import React, {useEffect, useRef, useState} from 'react';
import {ServerContext} from '@/state/server';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import tw from 'twin.macro';
import {Button} from '@/components/elements/button/index';
import getFileUploadUrl from "@/api/server/files/getFileUploadUrl";
import axios from "axios";
import useFileManagerSwr from "@/plugins/useFileManagerSwr";
import useFlash from "@/plugins/useFlash";
import useEventListener from "@/plugins/useEventListener";

export default () => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { mutate } = useFileManagerSwr();
    const [visible, setVisible] = useState(false);
    const [loading, setLoading] = useState(false);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const fileUploadInput = useRef<HTMLInputElement>(null);

    function dataURItoBlob(dataURI: string) {
        // convert base64 to raw binary data held in a string
        // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
        const byteString = atob(dataURI.split(',')[1]);

        // separate out the mime component
        const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to an ArrayBuffer
        const ab = new ArrayBuffer(byteString.length);

        // create a view into the buffer
        const ia = new Uint8Array(ab);

        // set the bytes of the buffer to the correct values
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob, and you're done
        return new Blob([ab], {type: mimeString});
    }

    const onFileSubmission = (files: FileList) => {
        const form = new FormData();
        Array.from(files).forEach((file) => {
            // Rename the file to the server-icon.png and resize it to 64x64
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement("canvas");
                    canvas.width = 64;
                    canvas.height = 64;
                    const ctx = canvas.getContext("2d");
                    if(ctx) {
                        ctx.drawImage(img, 0, 0, 64, 64);
                        const dataURL = canvas.toDataURL("image/png");
                        const blob = dataURItoBlob(dataURL);
                        if(blob) {
                            form.append("files", blob, "server-icon.png");
                        }
                    }
                }
                img.src = e.target!.result as string;
            }
        });

        setLoading(true);
        clearFlashes('files');
        getFileUploadUrl(uuid)
            .then((url) =>
                axios.post(`${url}&directory=/`, form, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
            )
            .then(() => mutate())
            .catch((error) => {
                console.error(error);
                clearAndAddHttpError({ error, key: 'files' });
            })
            .then(() => setVisible(false))
            .then(() => setLoading(false));
    };

    useEventListener(
        'dragenter',
        (e) => {
            e.stopPropagation();
            setVisible(true);
        },
        true
    );

    useEventListener(
        'dragexit',
        (e) => {
            e.stopPropagation();
            setVisible(false);
        },
        true
    );

    useEffect(() => {
        if (!visible) return;

        const hide = () => setVisible(false);

        window.addEventListener('keydown', hide);
        return () => {
            window.removeEventListener('keydown', hide);
        };
    }, [visible]);

    return (
        <TitledGreyBox title={'Upload Minecraft ServerIcon'} css={tw`relative`}>
            <p css={tw`text-sm`}>
                You can upload a icon for your minecraft server.&nbsp;
                <strong css={tw`font-medium`}>
                    The provided image will be resized to 64x64.
                    It should be a .png file.
                </strong>
            </p>
            <div css={tw`mt-6 text-right`}>
                <input
                    type={'file'}
                    ref={fileUploadInput}
                    css={tw`hidden`}
                    onChange={(e) => {
                        if (!e.currentTarget.files) return;

                        onFileSubmission(e.currentTarget.files);
                        if (fileUploadInput.current) {
                            fileUploadInput.current.files = null;
                        }
                    }}
                />
                <Button variant={Button.Variants.Secondary} onClick={() => {
                    fileUploadInput.current ? fileUploadInput.current.click() : setVisible(true);
                }}>
                   Upload
                </Button>
            </div>
        </TitledGreyBox>
    );
};
