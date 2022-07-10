import React, {useEffect, useRef, useState} from 'react';
import { ServerContext } from '@/state/server';
import TitledGreyBox from '@/components/elements/TitledGreyBox';
import tw from 'twin.macro';
import { Button } from '@/components/elements/button/index';
import { Dialog } from '@/components/elements/dialog';
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

    const onFileSubmission = (files: FileList) => {
        const form = new FormData();
        Array.from(files).forEach((file) => {
            if(file.type.startsWith("image/")) {
                // Convert to png
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => {
                    const base64data = reader.result as string;
                    const img = new Image();
                    img.src = base64data;
                    img.onload = () => {
                        const canvas = document.createElement("canvas");
                        canvas.width = 64;
                        canvas.height = 64;

                        const ctx = canvas.getContext("2d");
                        if(ctx) {
                            ctx.drawImage(img, 0, 0, 64, 64);
                            const png = canvas.toDataURL("image/png");
                            form.append("files", png);
                        }
                    }
                }
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
